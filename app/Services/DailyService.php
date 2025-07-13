<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class DailyService
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.daily.api_key');
        $this->baseUrl = 'https://api.daily.co/v1';
    }

    /**
     * Create a Daily.co room for video consultation
     */
    public function createRoom(string $roomName, array $properties = []): array
    {
        try {
            $defaultProperties = [
                'privacy' => 'private',
                'properties' => [
                    'max_participants' => 2, // Doctor and Patient only
                    'enable_chat' => false,
                    'enable_screenshare' => false,
                    'start_video_off' => false,
                    'start_audio_off' => false,
                    'exp' => time() + (60 * 60 * 2), // 2 hours expiry
                ]
            ];

            $roomData = array_merge($defaultProperties, $properties);
            $roomData['name'] = $roomName;

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/rooms', $roomData);

            if ($response->successful()) {
                return $response->json();
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
     * Create a meeting token for a participant
     */
    public function createMeetingToken(string $roomName, array $properties = []): array
    {
        try {
            $defaultProperties = [
                'room_name' => $roomName,
                'is_owner' => false,
                'exp' => time() + (60 * 60 * 2), // 2 hours expiry
            ];

            $tokenData = array_merge($defaultProperties, $properties);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/meeting-tokens', $tokenData);

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception('Failed to create Daily meeting token: ' . $response->body());
        } catch (Exception $e) {
            Log::error('Daily token creation failed: ' . $e->getMessage());
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
     * Create a consultation room for an appointment
     */
    public function createConsultationRoom(int $appointmentId, string $doctorName, string $patientName): array
    {
        $roomName = "consultation-{$appointmentId}-" . time();
        
        $properties = [
            'properties' => [
                'max_participants' => 2,
                'enable_chat' => true,
                'enable_screenshare' => true,
                'start_video_off' => false,
                'start_audio_off' => false,
                'exp' => time() + (60 * 60 * 3), // 3 hours for consultation
                'room_name' => $roomName,
            ]
        ];

        return $this->createRoom($roomName, $properties);
    }

    /**
     * Create tokens for doctor and patient
     */
    public function createConsultationTokens(string $roomName, int $doctorId, int $patientId): array
    {
        $doctorToken = $this->createMeetingToken($roomName, [
            'user_name' => 'Doctor',
            'user_id' => "doctor-{$doctorId}",
            'is_owner' => true,
            'enable_screenshare' => true,
        ]);

        $patientToken = $this->createMeetingToken($roomName, [
            'user_name' => 'Patient',
            'user_id' => "patient-{$patientId}",
            'is_owner' => false,
            'enable_screenshare' => false,
        ]);

        return [
            'doctor_token' => $doctorToken['token'],
            'patient_token' => $patientToken['token'],
            'room_url' => "https://{$roomName}.daily.co",
        ];
    }
}
