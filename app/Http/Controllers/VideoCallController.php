<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Services\DailyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VideoCallController extends Controller
{
    protected DailyService $dailyService;

    public function __construct(DailyService $dailyService)
    {
        $this->dailyService = $dailyService;
    }

    /**
     * Validate appointment access and return the appointment
     */
    private function validateAppointmentAccess($appointmentId): Appointment
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if (!$this->canAccessAppointment(Auth::user(), $appointment)) {
            abort(403, 'You do not have permission to access this appointment.');
        }

        return $appointment;
    }

    /**
     * Show prejoin interface for device testing
     */
    public function prejoin($appointmentId)
    {
        $appointment = $this->validateAppointmentAccess($appointmentId);
        return view('video-call.prejoin', compact('appointmentId', 'appointment'));
    }

    /**
     * Show video consultation interface
     */
    public function consultation($appointmentId)
    {
        $appointment = $this->validateAppointmentAccess($appointmentId);
        return view('video-call.consultation', compact('appointmentId', 'appointment'));
    }

    /**
     * Health check endpoint for connection testing
     * Lightweight endpoint that verifies authentication and connectivity
     * without creating any resources
     */
    public function healthCheck()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                    'timestamp' => now()->toISOString()
                ], 401);
            }

            // Verify Daily.co service is configured
            $apiKey = config('services.daily.api_key');
            if (!$apiKey) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Daily.co service not configured, but connection is working',
                    'user' => [
                        'id' => $user->id,
                        'role' => $user->role,
                        'name' => $user->name ?? $user->email
                    ],
                    'timestamp' => now()->toISOString()
                ], 200);
            }

            // Return success with user info and timestamp
            return response()->json([
                'status' => 'ok',
                'message' => 'Connection successful',
                'user' => [
                    'id' => $user->id,
                    'role' => $user->role,
                    'name' => $user->name ?? $user->email
                ],
                'timestamp' => now()->toISOString(),
                'service' => 'daily-video-calling',
                'daily_configured' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Health check failed: ' . $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * Create or get a consultation room - Integrated with appointment system and Daily domain
     */
    public function createRoom(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        $apiKey = config('services.daily.api_key');
        $dailyDomain = config('services.daily.domain');

        if (!$apiKey) {
            return response()->json(['error' => 'Daily.co API key not configured'], 500);
        }

        $appointmentId = $request->input('appointment_id');

        // Validate appointment access
        $appointment = $this->validateAppointmentAccess($appointmentId);

        try {
            // Use DailyService to create consultation room
            $roomData = $this->dailyService->createConsultationRoom($appointmentId, 'video');

            if ($roomData['success']) {
                // Update appointment with room info
                $appointment->update([
                    'video_room_name' => $roomData['room_name'],
                    'video_call_started_at' => now(),
                    'video_call_metadata' => [
                        'room_url' => $roomData['room_url'],
                        'consultation_type' => $roomData['consultation_type'],
                        'created_at' => now()->toISOString()
                    ]
                ]);

                return response()->json($roomData);
            } else {
                return response()->json(['error' => 'Failed to create room'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Failed to create consultation room: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create video room'], 500);
        }
    }

    /**
     * Generate meeting tokens for appointment participants
     */
    private function generateMeetingTokens(string $roomName, Appointment $appointment, string $apiKey): array
    {
        $tokens = [];

        try {
            // Doctor token
            $doctorResponse = Http::withToken($apiKey)
                ->post('https://api.daily.co/v1/meeting-tokens', [
                    'properties' => [
                        'room_name' => $roomName,
                        'user_name' => $appointment->doctor->name ?? 'Doctor',
                        'is_owner' => true,
                        'enable_recording' => true,
                        'exp' => time() + (60 * 60 * 4), // 4 hours
                    ],
                ]);

            if ($doctorResponse->successful()) {
                $doctorData = $doctorResponse->json();
                if (isset($doctorData['token'])) {
                    $tokens['doctor_token'] = $doctorData['token'];
                }
            } else {
                Log::warning('Doctor token generation failed', ['response' => $doctorResponse->body()]);
            }

            // Patient token
            $patientName = 'Patient';
            if ($appointment->patient) {
                $patientName = $appointment->patient->name ?? $patientName;
                if ($appointment->patient->user) {
                    $patientName = $appointment->patient->user->name ?? $patientName;
                }
            }
            $patientResponse = Http::withToken($apiKey)
                ->post('https://api.daily.co/v1/meeting-tokens', [
                    'properties' => [
                        'room_name' => $roomName,
                        'user_name' => $patientName,
                        'is_owner' => false,
                        'enable_recording' => false,
                        'exp' => time() + (60 * 60 * 4), // 4 hours
                    ],
                ]);

            if ($patientResponse->successful()) {
                $patientData = $patientResponse->json();
                if (isset($patientData['token'])) {
                    $tokens['patient_token'] = $patientData['token'];
                }
            } else {
                Log::warning('Patient token generation failed', ['response' => $patientResponse->body()]);
            }

        } catch (\Exception $e) {
            Log::error('Token generation failed: ' . $e->getMessage());
        }

        return $tokens;
    }

    /**
     * Start recording - Matching working example
     */
    public function startRecording(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        $appointmentId = $request->input('appointment_id');

        // Validate appointment access using centralized method
        $appointment = $this->validateAppointmentAccess($appointmentId);

        $roomName = "consultation-{$appointmentId}";
        $apiKey = config('services.daily.api_key');

        $response = Http::withToken($apiKey)
            ->post("https://api.daily.co/v1/rooms/{$roomName}/recordings/start", [
                'width' => 854,
                'height' => 480,
                'fps' => 24,
                'videoBitrate' => 1000,
                'audioBitrate' => 64,
                'layout' => [
                    'preset' => 'default'
                ]
            ]);

        $data = $response->json();
        if ($response->successful()) {
            // Update appointment with recording ID
            if ($appointmentId) {
                $appointment->update([
                    'recording_id' => $data['recordingId'] ?? null
                ]);
            }
            return response()->json($data['recordingId']);
        }
        return response()->json(['error' => $data], $response->status());
    }

    /**
     * Stop recording - Matching working example
     */
    public function stopRecording(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        $appointmentId = $request->input('appointment_id');

        // Verify user has permission to stop recording this appointment
        $appointment = Appointment::findOrFail($appointmentId);

        $user = Auth::user();
        if (!$user || !$this->canAccessAppointment($user, $appointment)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $roomName = "consultation-{$appointmentId}";
        $apiKey = config('services.daily.api_key');

        $response = Http::withToken($apiKey)
            ->post("https://api.daily.co/v1/rooms/{$roomName}/recordings/stop", []);

        $data = $response->json();
        if ($response->successful()) {
            return response()->json($data);
        }

        return response()->json(['error' => $data], $response->status());
    }

    /**
     * List recordings - Matching working example
     */
    public function listRecordings()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $apiKey = config('services.daily.api_key');
        $response = Http::withToken($apiKey)
            ->get('https://api.daily.co/v1/recordings');

        if ($response->successful()) {
            $allRecordings = $response->json();

            // Filter recordings based on user's appointments
            $userAppointments = Appointment::where(function($query) use ($user) {
                if ($user->role === 'admin') {
                    return; // Admin can see all
                } elseif ($user->role === 'doctor') {
                    if ($user->doctor) {
                        $query->where('doctor_id', $user->doctor->id);
                    } else {
                        $query->whereRaw('1 = 0'); // No results if doctor relationship missing
                    }
                } elseif ($user->role === 'patient') {
                    if ($user->patient) {
                        $query->where('patient_id', $user->patient->id);
                    } else {
                        $query->whereRaw('1 = 0'); // No results if patient relationship missing
                    }
                }
            })->pluck('video_room_name')->filter()->toArray();

            $filteredRecordings = collect($allRecordings['data'] ?? [])
                ->filter(function($recording) use ($userAppointments, $user) {
                    if ($user->role === 'admin') return true;
                    return in_array($recording['room_name'] ?? null, $userAppointments);
                })->values();

            return response()->json(['data' => $filteredRecordings]);
        }

        return response()->json([
            'error' => 'Unable to fetch recordings',
            'status' => $response->status(),
        ], $response->status());
    }

    /**
     * Get recording access link - Matching working example
     */
    public function getRecording($meetingId)
    {
        // Verify the user has access to this recording
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if user has any appointment with this recording
        $hasAccess = Appointment::where('recording_id', $meetingId)
            ->where(function($query) use ($user) {
                if ($user->role === 'admin') {
                    return; // Admin can access all
                } elseif ($user->role === 'doctor') {
                    if ($user->doctor) {
                        $query->where('doctor_id', $user->doctor->id);
                    } else {
                        $query->whereRaw('1 = 0'); // No results if doctor relationship missing
                    }
                } elseif ($user->role === 'patient') {
                    if ($user->patient) {
                        $query->where('patient_id', $user->patient->id);
                    } else {
                        $query->whereRaw('1 = 0'); // No results if patient relationship missing
                    }
                }
            })->exists();

        if (!$hasAccess && $user->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $apiKey = config('services.daily.api_key');
        $response = Http::withToken($apiKey)
            ->get("https://api.daily.co/v1/recordings/$meetingId/access-link");

        return $response->json();
    }

    /**
     * End video call and update appointment
     */
    public function endCall(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        $appointmentId = $request->input('appointment_id');

        if ($appointmentId) {
            $appointment = Appointment::find($appointmentId);
            if ($appointment) {
                // Verify user has permission to end this call
                $user = Auth::user();
                if (!$user || !$this->canAccessAppointment($user, $appointment)) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }

                $appointment->update([
                    'video_call_ended_at' => now(),
                    'status' => 'completed'
                ]);

                return response()->json(['success' => true, 'message' => 'Call ended successfully']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Appointment not found']);
    }

    /**
     * Check if user can access the appointment
     */
    private function canAccessAppointment($user, Appointment $appointment): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'doctor') {
            return $user->doctor && $appointment->doctor_id === $user->doctor->id;
        }

        if ($user->role === 'patient') {
            return $user->patient && $appointment->patient_id === $user->patient->id;
        }

        return false;
    }
}
