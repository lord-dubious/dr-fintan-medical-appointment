<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Services\DailyService;
use Illuminate\Http\JsonResponse;

class VideoCallController extends Controller
{
    protected DailyService $dailyService;

    public function __construct(DailyService $dailyService)
    {
        $this->dailyService = $dailyService;
    }

    /**
     * Start a consultation call
     */
    public function startConsultation(Request $request, Appointment $appointment): JsonResponse
    {
        try {
            // Verify user has access to this appointment
            $user = Auth::user();
            if (!$this->canAccessAppointment($user, $appointment)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized access to this appointment'
                ], 403);
            }

            // Create or get existing consultation room
            $roomData = $this->dailyService->createConsultationRoom(
                $appointment->id,
                $appointment->consultation_type ?? 'video'
            );

            if (!$roomData['success']) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to create consultation room'
                ], 500);
            }

            // Determine user role and get appropriate token
            $userRole = $this->getUserRole($user, $appointment);
            $token = $roomData['tokens'][$userRole] ?? null;

            if (!$token) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to generate access token'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'room_url' => $roomData['room_url'],
                'room_name' => $roomData['room_name'],
                'token' => $token,
                'consultation_type' => $roomData['consultation_type'],
                'user_role' => $userRole,
                'appointment_id' => $appointment->id
            ]);

        } catch (\Exception $e) {
            \Log::error('Video call start failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to start consultation'
            ], 500);
        }
    }

    /**
     * Join an existing consultation
     */
    public function joinConsultation(Request $request, Appointment $appointment): JsonResponse
    {
        return $this->startConsultation($request, $appointment);
    }

    /**
     * End a consultation call
     */
    public function endConsultation(Request $request, Appointment $appointment): JsonResponse
    {
        try {
            // Update appointment status
            $appointment->update(['status' => 'completed']);

            return response()->json([
                'success' => true,
                'message' => 'Consultation ended successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Video call end failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to end consultation'
            ], 500);
        }
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
            return $appointment->doctor_id === $user->doctor->id ?? false;
        }

        if ($user->role === 'patient') {
            return $appointment->patient_id === $user->patient->id ?? false;
        }

        return false;
    }

    /**
     * Get user role for the consultation
     */
    private function getUserRole($user, Appointment $appointment): string
    {
        if ($user->role === 'doctor' || $user->role === 'admin') {
            return 'doctor';
        }

        return 'patient';
    }
}
