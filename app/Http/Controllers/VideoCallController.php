<?php

namespace App\Http\Controllers;

use App\Facades\Daily;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VideoCallController extends Controller
{
    /**
     * Show consultation page for appointment
     */
    public function consultation($appointmentId)
    {
        $appointment = $this->validateAppointmentAccess($appointmentId);
        $user = Auth::user();

        // Determine user role based on relationship
        $userRole = 'patient'; // default
        if ($user->doctor && $user->doctor->id === $appointment->doctor_id) {
            $userRole = 'doctor';
        }

        return view('video-call.consultation', compact('appointment', 'userRole'));
    }

    /**
     * Create or get Daily.co room for appointment
     */
    public function createRoom($appointmentId)
    {
        try {
            $appointment = $this->validateAppointmentAccess($appointmentId);

            // Check if room already exists
            if ($appointment->video_room_name) {
                try {
                    $existingRoom = Daily::room($appointment->video_room_name);

                    // Generate fresh tokens
                    $doctorToken = $this->createMeetingToken($appointment->video_room_name, 'doctor', true);
                    $patientToken = $this->createMeetingToken($appointment->video_room_name, 'patient', false);

                    return response()->json([
                        'success' => true,
                        'room_name' => $appointment->video_room_name,
                        'room_url' => $existingRoom['url'],
                        'tokens' => [
                            'doctor' => $doctorToken,
                            'patient' => $patientToken,
                        ],
                    ]);
                } catch (\Exception $e) {
                    // Room doesn't exist anymore, create new one
                    Log::info("Room {$appointment->video_room_name} not found, creating new one");
                }
            }

            // Create new room with valid name format (lowercase, alphanumeric, hyphens only)
            $roomName = 'appt-'.$appointmentId.'-'.strtolower(Str::random(8));

            $roomData = [
                'name' => $roomName,
                'privacy' => 'private',
                'properties' => [
                    'max_participants' => 2,
                    'enable_chat' => true,
                    'enable_screenshare' => true,
                    'exp' => time() + (60 * 60 * 4), // 4 hours
                ],
            ];

            Log::info('Creating Daily.co room', ['room_data' => $roomData]);

            $room = Daily::createRoom($roomData);

            Log::info('Daily.co room created successfully', ['room' => $room]);

            // Save room name to appointment
            $appointment->update(['video_room_name' => $roomName]);

            // Generate tokens
            $doctorToken = $this->createMeetingToken($roomName, 'doctor', true);
            $patientToken = $this->createMeetingToken($roomName, 'patient', false);

            return response()->json([
                'success' => true,
                'room_name' => $roomName,
                'room_url' => $room['url'],
                'tokens' => [
                    'doctor' => $doctorToken,
                    'patient' => $patientToken,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create Daily room: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Failed to create video room: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Health check endpoint
     */
    public function healthCheck()
    {
        try {
            $user = Auth::user();

            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                    'timestamp' => now()->toISOString(),
                ], 401);
            }

            // Test Daily.co configuration
            $dailyConfigured = ! empty(config('daily.token')) && ! empty(config('daily.domain'));

            return response()->json([
                'status' => $dailyConfigured ? 'ok' : 'warning',
                'message' => $dailyConfigured ? 'Service is running' : 'Daily.co not fully configured',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'has_patient' => $user->patient ? true : false,
                    'has_doctor' => $user->doctor ? true : false,
                    'patient_id' => $user->patient ? $user->patient->id : null,
                    'doctor_id' => $user->doctor ? $user->doctor->id : null,
                ],
                'daily_configured' => $dailyConfigured,
                'timestamp' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            Log::error('Health check failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Health check failed: '.$e->getMessage(),
                'timestamp' => now()->toISOString(),
            ], 500);
        }
    }

    /**
     * Create meeting token for user
     */
    private function createMeetingToken(string $roomName, string $userRole, bool $isOwner = false): ?string
    {
        try {
            $tokenData = [
                'properties' => [
                    'room_name' => $roomName,
                    'user_name' => ucfirst($userRole),
                    'is_owner' => $isOwner,
                    'exp' => time() + (60 * 60 * 4), // 4 hours
                ],
            ];

            $response = Daily::createMeetingToken($tokenData);

            return $response['token'] ?? null;
        } catch (\Exception $e) {
            Log::error('Meeting token creation failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Validate appointment access and return the appointment
     */
    private function validateAppointmentAccess($appointmentId): Appointment
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $user = Auth::user();

        Log::info('Validating appointment access', [
            'appointment_id' => $appointmentId,
            'user_id' => $user->id,
            'user_role' => $user->role,
            'appointment_patient_id' => $appointment->patient_id,
            'appointment_doctor_id' => $appointment->doctor_id,
            'user_has_patient' => $user->patient ? true : false,
            'user_has_doctor' => $user->doctor ? true : false,
            'user_patient_id' => $user->patient ? $user->patient->id : null,
            'user_doctor_id' => $user->doctor ? $user->doctor->id : null,
        ]);

        if (! $this->canAccessAppointment($user, $appointment)) {
            Log::warning('Access denied to appointment', [
                'appointment_id' => $appointmentId,
                'user_id' => $user->id,
            ]);
            abort(403, 'You do not have permission to access this appointment.');
        }

        return $appointment;
    }

    /**
     * Check if user can access the appointment
     */
    private function canAccessAppointment($user, Appointment $appointment): bool
    {
        // Check if user is the patient
        if ($user->patient && $user->patient->id === $appointment->patient_id) {
            return true;
        }

        // Check if user is the doctor
        if ($user->doctor && $user->doctor->id === $appointment->doctor_id) {
            return true;
        }

        return false;
    }
}
