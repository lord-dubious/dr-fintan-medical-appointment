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
     * Show prejoin interface for device testing
     */
    public function prejoin($appointmentId)
    {
        // Validate appointment exists and user has access
        $appointment = Appointment::findOrFail($appointmentId);

        // Check if user can access this appointment
        if (!$this->canAccessAppointment(Auth::user(), $appointment)) {
            abort(403, 'You do not have permission to access this appointment.');
        }

        return view('video-call.prejoin', compact('appointmentId', 'appointment'));
    }

    /**
     * Show video consultation interface
     */
    public function consultation($appointmentId)
    {
        // Validate appointment exists and user has access
        $appointment = Appointment::findOrFail($appointmentId);

        // Check if user can access this appointment
        if (!$this->canAccessAppointment(Auth::user(), $appointment)) {
            abort(403, 'You do not have permission to access this appointment.');
        }

        return view('video-call.consultation', compact('appointmentId', 'appointment'));
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

        // Validate appointment if provided
        if ($appointmentId) {
            $appointment = Appointment::with(['doctor', 'patient'])->find($appointmentId);
            if (!$appointment) {
                return response()->json(['error' => 'Appointment not found'], 404);
            }

            // Check if user has access to this appointment
            $user = Auth::user();
            if (!$this->canAccessAppointment($user, $appointment)) {
                return response()->json(['error' => 'Unauthorized access to this appointment'], 403);
            }
        }

        // Medical consultations require appointment ID - no demo rooms allowed
        if (!$appointmentId) {
            return response()->json(['error' => 'Appointment ID required for medical consultations'], 400);
        }

        $roomName = "consultation-{$appointmentId}";

        // Check if room already exists
        $check = Http::withToken($apiKey)
            ->get("https://api.daily.co/v1/rooms/{$roomName}");

        if ($check->status() === 200) {
            // Update appointment with room info if not already set
            if ($appointmentId && $appointment && !$appointment->video_room_name) {
                $appointment->update([
                    'video_room_name' => $roomName,
                    'video_call_started_at' => now()
                ]);
            }
            return $check->json(); // Reuse existing room
        }

        // Create new room with custom domain
        // Room expiry is configurable via env, defaults to 4 hours (14400 seconds)
        $roomExpirySeconds = config('services.daily.room_expiry_seconds', 60 * 60 * 4);

        $roomProperties = [
            'name' => $roomName,
            'properties' => [
                'enable_recording' => 'cloud',
                'max_participants' => 2,
                'start_video_off' => false,
                'start_audio_off' => false,
                'enable_chat' => true,
                'enable_screenshare' => true,
                'exp' => time() + $roomExpirySeconds,
            ],
        ];

        // Add domain if configured
        if ($dailyDomain) {
            $roomProperties['properties']['domain_config'] = [
                'domain' => $dailyDomain
            ];
        }

        $response = Http::withToken($apiKey)
            ->post('https://api.daily.co/v1/rooms', $roomProperties);

        $roomData = $response->json();

        // Use custom domain URL if available
        if ($response->successful() && $dailyDomain) {
            $roomData['custom_url'] = "https://{$dailyDomain}/{$roomName}";
        }

        // Update appointment with room info
        if ($appointmentId && $appointment && $response->successful()) {
            $customUrl = $dailyDomain ? "https://{$dailyDomain}/{$roomName}" : ($roomData['url'] ?? null);
            $appointment->update([
                'video_room_name' => $roomName,
                'video_call_started_at' => now(),
                'video_call_metadata' => [
                    'room_url' => $roomData['url'] ?? null,
                    'custom_url' => $customUrl,
                    'daily_domain' => $dailyDomain,
                    'created_at' => now()->toISOString()
                ]
            ]);
        }

        // Generate meeting tokens for secure access
        if ($response->successful() && $appointmentId && $appointment) {
            $tokens = $this->generateMeetingTokens($roomName, $appointment, $apiKey);
            $roomData['tokens'] = $tokens;
        }

        return $roomData;
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

        // Verify user has permission to record this appointment
        $appointment = Appointment::find($appointmentId);
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $user = Auth::user();
        if (!$user || !$this->canAccessAppointment($user, $appointment)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $roomName = $appointmentId ? "consultation-{$appointmentId}" : 'demo-consultation';
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
                $appointment = Appointment::where('id', $appointmentId)->first();
                if ($appointment) {
                    $appointment->update([
                        'recording_id' => $data['recordingId'] ?? null
                    ]);
                }
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
        $appointment = Appointment::find($appointmentId);
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $user = Auth::user();
        if (!$user || !$this->canAccessAppointment($user, $appointment)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $roomName = $appointmentId ? "consultation-{$appointmentId}" : 'demo-consultation';
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
                    $query->where('doctor_id', $user->doctor->id ?? null);
                } elseif ($user->role === 'patient') {
                    $query->where('patient_id', $user->patient->id ?? null);
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
                    $query->where('doctor_id', $user->doctor->id ?? null);
                } elseif ($user->role === 'patient') {
                    $query->where('patient_id', $user->patient->id ?? null);
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
