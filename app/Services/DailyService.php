<?php

namespace App\Services;

use App\Facades\Daily;
use App\Models\Appointment;
use Exception;
use Illuminate\Support\Facades\Log;

class DailyService
{
    public function __construct()
    {
        if (! config('daily.token')) {
            throw new \Exception('Daily.co API key not configured');
        }
    }

    /**
     * Create a Daily.co room for consultation (video or audio)
     */
    public function createConsultationRoom(int $appointmentId, string $consultationType = 'video'): array
    {
        try {
            $roomName = "consultation-{$appointmentId}-".time();

            // Configure room based on consultation type
            $isVideoCall = $consultationType === 'video';

            $roomData = [
                'name' => $roomName,
                'privacy' => 'private',
                'properties' => [
                    'max_participants' => 2,
                    'enable_chat' => true,
                    'enable_screenshare' => $isVideoCall, // Only for video calls
                    'start_video_off' => ! $isVideoCall, // Video off for audio-only
                    'start_audio_off' => false,
                    'enable_recording' => false,
                    'enable_dialin' => false,
                    'enable_dialout' => false,
                    'owner_only_broadcast' => false,
                    'enable_prejoin_ui' => true,
                    'enable_network_ui' => true,
                    'enable_people_ui' => true,
                    'exp' => time() + (60 * 60 * 3), // 3 hours expiry
                ],
            ];

            // Use the Daily SDK to create the room
            $roomResponse = Daily::createRoom($roomData);

            // Generate meeting tokens for doctor and patient
            $doctorToken = $this->createMeetingToken($roomResponse['name'], 'doctor', true);
            $patientToken = $this->createMeetingToken($roomResponse['name'], 'patient', false);

            return [
                'success' => true,
                'room' => $roomResponse,
                'room_url' => $roomResponse['url'],
                'room_name' => $roomResponse['name'],
                'consultation_type' => $consultationType,
                'tokens' => [
                    'doctor' => $doctorToken,
                    'patient' => $patientToken,
                ],
            ];
        } catch (Exception $e) {
            Log::error('Daily room creation failed: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Get room information
     */
    public function getRoom(string $roomName): array
    {
        try {
            return Daily::room($roomName);
        } catch (Exception $e) {
            Log::error('Daily room retrieval failed: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a room
     */
    public function deleteRoom(string $roomName): bool
    {
        try {
            Daily::deleteRoom($roomName);

            return true;
        } catch (Exception $e) {
            Log::error('Daily room deletion failed: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Create tokens for doctor and patient
     */
    public function createConsultationTokens(
        string $roomName,
        int $doctorId,
        int $patientId,
        string $doctorName = 'Doctor',
        string $patientName = 'Patient'
    ): array {
        $doctorToken = $this->createMeetingToken($roomName, [
            'user_name' => $doctorName,
            'user_id' => "doctor-{$doctorId}",
            'is_owner' => true,
            'enable_screenshare' => true,
        ]);

        $patientToken = $this->createMeetingToken($roomName, [
            'user_name' => $patientName,
            'user_id' => "patient-{$patientId}",
            'is_owner' => false,
            'enable_screenshare' => false,
        ]);

        return [
            'doctor_token' => $doctorToken['token'],
            'patient_token' => $patientToken['token'],
            'room_url' => 'https://'.config('services.daily.domain')."/{$roomName}",
        ];
    }

    /**
     * Create a meeting token for a specific user
     */
    public function createMeetingToken(string $roomName, string $userRole, bool $isOwner = false): ?string
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
        } catch (Exception $e) {
            Log::error('Meeting token creation failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Delete expired rooms for completed appointments
     *
     * This method finds all completed appointments with video rooms that ended
     * more than 1 hour ago and deletes the associated Daily.co rooms.
     *
     * @return int The number of rooms successfully deleted
     */
    public function cleanupExpiredRooms(): int
    {
        $completedAppointments = Appointment::where('status', 'completed')
            ->whereNotNull('video_room_name')
            ->where('video_call_ended_at', '<', now()->subHours(1))
            ->get();

        $deletedCount = 0;

        foreach ($completedAppointments as $appointment) {
            try {
                Daily::deleteRoom($appointment->video_room_name);
                $appointment->update(['video_room_name' => null]);
                $deletedCount++;
            } catch (Exception $e) {
                Log::warning("Failed to delete room {$appointment->video_room_name}: ".$e->getMessage());
            }
        }

        return $deletedCount;
    }

    /**
     * Get expired rooms that would be deleted (for dry-run)
     */
    public function getExpiredRooms(): array
    {
        return Appointment::where('status', 'completed')
            ->whereNotNull('video_room_name')
            ->where('video_call_ended_at', '<', now()->subHours(1))
            ->select('id', 'video_room_name')
            ->get()
            ->map(function ($appointment) {
                return [
                    'name' => $appointment->video_room_name,
                    'appointment_id' => $appointment->id,
                ];
            })
            ->toArray();
    }

    /**
     * Verify that the DailyService is properly configured and accessible
     *
     * @return bool True if the service is properly configured
     */
    public function isConfigured(): bool
    {
        return ! empty(config('daily.token')) && ! empty(config('daily.domain'));
    }
}
