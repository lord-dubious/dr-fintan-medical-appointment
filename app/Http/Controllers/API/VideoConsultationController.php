<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DailyService;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class VideoConsultationController extends Controller
{
    private DailyService $dailyService;

    public function __construct(DailyService $dailyService)
    {
        $this->dailyService = $dailyService;
    }

    /**
     * Check if the current user is authorized for the appointment
     */
    private function isAuthorizedForAppointment(Appointment $appointment): bool
    {
        $user = Auth::user();
        return ($user->role === 'doctor' && $user->doctor && $user->doctor->id === $appointment->doctor_id) ||
               ($user->role === 'patient' && $user->patient && $user->patient->id === $appointment->patient_id);
    }

    /**
     * Create a video consultation room for an appointment
     */
    public function createConsultationRoom(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'appointment_id' => 'required|integer|exists:appointments,id',
            ]);

            $appointment = Appointment::with(['doctor', 'patient.user'])->findOrFail($request->appointment_id);

            if (!$this->isAuthorizedForAppointment($appointment)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Get patient name (fallback to patient name if no user)
            $patientName = $appointment->patient->user ? $appointment->patient->user->name : $appointment->patient->name;

            // Create Daily.co room
            $room = $this->dailyService->createConsultationRoom(
                $appointment->id,
                $appointment->doctor->name,
                $patientName
            );

            // Create tokens for both participants
            $tokens = $this->dailyService->createConsultationTokens(
                $room['name'],
                $appointment->doctor_id,
                $appointment->patient_id,
                $appointment->doctor->name,
                $patientName
            );

            return response()->json([
                'success' => true,
                'room_name' => $room['name'],
                'room_url' => $room['url'],
                'tokens' => $tokens,
                'appointment' => [
                    'id' => $appointment->id,
                    'doctor_name' => $appointment->doctor->name,
                    'patient_name' => $patientName,
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Video consultation room creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to create consultation room'
            ], 500);
        }
    }

    /**
     * Get consultation room details
     */
    public function getConsultationRoom(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'room_name' => 'required|string',
                'appointment_id' => 'required|integer|exists:appointments,id',
            ]);

            $appointment = Appointment::with(['doctor', 'patient.user'])->findOrFail($request->appointment_id);

            if (!$this->isAuthorizedForAppointment($appointment)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Get room details
            $room = $this->dailyService->getRoom($request->room_name);

            // Get patient name (fallback to patient name if no user)
            $patientName = $appointment->patient->user ? $appointment->patient->user->name : $appointment->patient->name;

            // Create new tokens (in case old ones expired)
            $tokens = $this->dailyService->createConsultationTokens(
                $request->room_name,
                $appointment->doctor_id,
                $appointment->patient_id,
                $appointment->doctor->name,
                $patientName
            );

            return response()->json([
                'success' => true,
                'room' => $room,
                'tokens' => $tokens,
            ]);

        } catch (Exception $e) {
            Log::error('Get consultation room failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to get consultation room'
            ], 500);
        }
    }

    /**
     * Create an audio-only consultation
     */
    public function createAudioConsultation(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'appointment_id' => 'required|integer|exists:appointments,id',
            ]);

            $appointment = Appointment::with(['doctor', 'patient.user'])->findOrFail($request->appointment_id);

            if (!$this->isAuthorizedForAppointment($appointment)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $roomName = "audio-consultation-{$appointment->id}-" . time();
            
            // Create audio-only room
            $properties = [
                'properties' => [
                    'max_participants' => 2,
                    'enable_chat' => true,
                    'enable_screenshare' => false,
                    'start_video_off' => true, // Audio only
                    'start_audio_off' => false,
                    'exp' => time() + (60 * 60 * 3), // 3 hours
                ]
            ];

            $room = $this->dailyService->createRoom($roomName, $properties);

            // Get patient name (fallback to patient name if no user)
            $patientName = $appointment->patient->user ? $appointment->patient->user->name : $appointment->patient->name;

            // Create tokens
            $tokens = $this->dailyService->createConsultationTokens(
                $room['name'],
                $appointment->doctor_id,
                $appointment->patient_id,
                $appointment->doctor->name,
                $patientName
            );

            return response()->json([
                'success' => true,
                'room_name' => $room['name'],
                'room_url' => $room['url'],
                'tokens' => $tokens,
                'type' => 'audio_only',
                'appointment' => [
                    'id' => $appointment->id,
                    'doctor_name' => $appointment->doctor->name,
                    'patient_name' => $patientName,
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Audio consultation creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to create audio consultation'
            ], 500);
        }
    }

    /**
     * End consultation and cleanup room
     */
    public function endConsultation(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'room_name' => 'required|string',
                'appointment_id' => 'required|integer|exists:appointments,id',
            ]);

            $appointment = Appointment::findOrFail($request->appointment_id);

            if (!$this->isAuthorizedForAppointment($appointment)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Delete the room
            $deleted = $this->dailyService->deleteRoom($request->room_name);

            return response()->json([
                'success' => $deleted,
                'message' => $deleted ? 'Consultation ended successfully' : 'Failed to end consultation'
            ]);

        } catch (Exception $e) {
            Log::error('End consultation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to end consultation'
            ], 500);
        }
    }
}
