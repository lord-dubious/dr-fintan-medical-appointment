<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;
use Exception;

class DailyService
{
    private string $apiKey;
    private string $baseUrl;
    private string $domain;

    public function __construct()
    {
        $this->apiKey = config('services.daily.api_key');
        $this->domain = config('services.daily.domain');
        $this->baseUrl = 'https://api.daily.co/v1';

        if (!$this->apiKey) {
            throw new \Exception('Daily.co API key not configured');
        }
    }

    /**
     * Create a Daily.co room for consultation (video or audio)
     */
    public function createConsultationRoom(int $appointmentId, string $consultationType = 'video'): array
    {
        try {
            $roomName = "consultation-{$appointmentId}-" . time();

            // Configure room based on consultation type
            $isVideoCall = $consultationType === 'video';

            $roomData = [
                'name' => $roomName,
                'privacy' => 'private',
                'properties' => [
                    'max_participants' => 2,
                    'enable_chat' => true,
                    'enable_screenshare' => $isVideoCall, // Only for video calls
                    'start_video_off' => !$isVideoCall, // Video off for audio-only
                    'start_audio_off' => false,
                    'enable_recording' => false,
                    'enable_dialin' => false,
                    'enable_dialout' => false,
                    'owner_only_broadcast' => false,
                    'enable_prejoin_ui' => true,
                    'enable_network_ui' => true,
                    'enable_people_ui' => true,
                    'exp' => time() + (60 * 60 * 3), // 3 hours expiry
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/rooms', $roomData);

            if ($response->successful()) {
                $roomData = $response->json();

                // Generate meeting tokens for doctor and patient
                $doctorToken = $this->createMeetingToken($roomData['name'], 'doctor', true);
                $patientToken = $this->createMeetingToken($roomData['name'], 'patient', false);

                return [
                    'success' => true,
                    'room' => $roomData,
                    'room_url' => $roomData['url'],
                    'room_name' => $roomData['name'],
                    'consultation_type' => $consultationType,
                    'tokens' => [
                        'doctor' => $doctorToken,
                        'patient' => $patientToken
                    ]
                ];
            }

            throw new Exception('Failed to create Daily room: ' . $response->body());
        } catch (Exception $e) {
            Log::error('Daily room creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get room information
     */
    public function getRoom(string $roomName): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/rooms/' . $roomName);

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception('Failed to get Daily room: ' . $response->body());
        } catch (Exception $e) {
            Log::error('Daily room retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }



    /**
     * Delete a room
     */
    public function deleteRoom(string $roomName): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->delete($this->baseUrl . '/rooms/' . $roomName);

            return $response->successful();
        } catch (Exception $e) {
            Log::error('Daily room deletion failed: ' . $e->getMessage());
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
            'room_url' => "https://" . config('services.daily.domain') . "/{$roomName}",
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
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/meeting-tokens', $tokenData);

            if ($response->successful()) {
                $data = $response->json();
                return $data['token'] ?? null;
            }

            Log::error('Failed to create meeting token: ' . $response->body());
            return null;
        } catch (Exception $e) {
            Log::error('Meeting token creation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete expired rooms for completed appointments
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
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ])->delete($this->baseUrl . '/rooms/' . $appointment->video_room_name);

                if ($response->successful()) {
                    $appointment->update(['video_room_name' => null]);
                    $deletedCount++;
                }
            } catch (Exception $e) {
                Log::warning("Failed to delete room {$appointment->video_room_name}: " . $e->getMessage());
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
            ->map(function($appointment) {
                return [
                    'name' => $appointment->video_room_name,
                    'appointment_id' => $appointment->id
                ];
            })
            ->toArray();
    }
}
