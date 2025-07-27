<?php

namespace App\Services;

use NotificationAPI\NotificationAPI;
use Illuminate\Support\Facades\Log;

class NotificationsApiService
{
    private $notificationAPI;

    public function __construct()
    {
        $this->notificationAPI = new NotificationAPI(
            config('services.notificationapi.client_id'),
            config('services.notificationapi.client_secret')
        );
    }

    /**
     * Send notification using NotificationAPI PHP SDK
     */
    public function sendNotification(array $data)
    {
        try {
            $result = $this->notificationAPI->send([
                'notificationId' => $data['notification_id'] ?? uniqid(),
                'user' => [
                    'id' => $data['user_id'],
                    'email' => $data['email'] ?? null,
                    'number' => $data['phone'] ?? null,
                ],
                'mergeTags' => $data['merge_tags'] ?? [],
                'templateId' => $data['template_id'] ?? null,
                'title' => $data['title'] ?? null,
                'message' => $data['message'] ?? null,
                'channels' => $data['channels'] ?? ['inApp', 'email', 'sms', 'push'],
                'customData' => $data['custom_data'] ?? [],
            ]);

            Log::info('NotificationAPI: Notification sent successfully', [
                'user_id' => $data['user_id'],
                'notification_id' => $data['notification_id'] ?? 'auto-generated',
                'template_id' => $data['template_id'] ?? null
            ]);
            
            return $result;
        } catch (\Exception $e) {
            Log::error('NotificationAPI error: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send appointment reminder notification
     */
    public function sendAppointmentReminder($appointment, $templateId = 'appointment_reminder', $reminderTime = '24 hours')
    {
        $patient = $appointment->patient;
        $doctor = $appointment->doctor;

        return $this->sendNotification([
            'notification_id' => 'appointment_reminder_' . $appointment->id . '_' . time(),
            'user_id' => $patient->user->id,
            'email' => $patient->user->email,
            'phone' => $patient->user->phone,
            'template_id' => $templateId,
            'merge_tags' => [
                'patient_name' => $patient->user->name,
                'doctor_name' => $doctor->name,
                'appointment_date' => $appointment->appointment_date->format('F j, Y'),
                'appointment_time' => $appointment->appointment_time,
                'appointment_id' => $appointment->id,
                'reminder_time' => $reminderTime,
                'doctor_specialization' => $doctor->specializations[0] ?? 'General Practice',
                'consultation_fee' => number_format($doctor->consultation_fee ?? 0),
            ],
            'channels' => ['inApp', 'email', 'sms', 'push'],
            'custom_data' => [
                'appointment_id' => $appointment->id,
                'type' => 'appointment_reminder',
                'action_url' => route('mobile.user.appointments'),
                'reminder_type' => $reminderTime
            ]
        ]);
    }

    /**
     * Send appointment confirmation notification
     */
    public function sendAppointmentConfirmation($appointment)
    {
        $patient = $appointment->patient;
        $doctor = $appointment->doctor;

        return $this->sendNotification([
            'notification_id' => 'appointment_confirmed_' . $appointment->id,
            'user_id' => $patient->user->id,
            'email' => $patient->user->email,
            'phone' => $patient->user->phone,
            'template_id' => 'appointment_confirmed',
            'merge_tags' => [
                'patient_name' => $patient->user->name,
                'doctor_name' => $doctor->name,
                'appointment_date' => $appointment->appointment_date->format('F j, Y'),
                'appointment_time' => $appointment->appointment_time,
                'consultation_fee' => number_format($doctor->consultation_fee ?? 0),
                'doctor_specialization' => $doctor->specializations[0] ?? 'General Practice',
            ],
            'channels' => ['inApp', 'email', 'push'],
            'custom_data' => [
                'appointment_id' => $appointment->id,
                'type' => 'appointment_confirmed',
                'action_url' => route('mobile.user.appointments')
            ]
        ]);
    }

    /**
     * Send appointment cancellation notification
     */
    public function sendAppointmentCancellation($appointment)
    {
        $patient = $appointment->patient;
        $doctor = $appointment->doctor;

        return $this->sendNotification([
            'notification_id' => 'appointment_cancelled_' . $appointment->id,
            'user_id' => $patient->user->id,
            'email' => $patient->user->email,
            'phone' => $patient->user->phone,
            'template_id' => 'appointment_cancelled',
            'merge_tags' => [
                'patient_name' => $patient->user->name,
                'doctor_name' => $doctor->name,
                'appointment_date' => $appointment->appointment_date->format('F j, Y'),
                'appointment_time' => $appointment->appointment_time,
                'cancellation_reason' => 'Administrative decision',
            ],
            'channels' => ['inApp', 'email', 'sms'],
            'custom_data' => [
                'appointment_id' => $appointment->id,
                'type' => 'appointment_cancelled',
                'action_url' => route('mobile.auth.appointment')
            ]
        ]);
    }

    /**
     * Send new blog post notification
     */
    public function sendNewBlogPostNotification($blogPost, $users)
    {
        foreach ($users as $user) {
            $this->sendNotification([
                'notification_id' => 'new_blog_post_' . $blogPost->id . '_' . $user->id,
                'user_id' => $user->id,
                'email' => $user->email,
                'template_id' => 'new_blog_post',
                'merge_tags' => [
                    'user_name' => $user->name,
                    'post_title' => $blogPost->title,
                    'post_excerpt' => $blogPost->excerpt,
                    'author_name' => $blogPost->author->name,
                    'reading_time' => $blogPost->reading_time,
                ],
                'channels' => ['inApp', 'email'],
                'custom_data' => [
                    'blog_post_id' => $blogPost->id,
                    'type' => 'new_blog_post',
                    'action_url' => route('blog.show', $blogPost->slug)
                ]
            ]);
        }
    }

    /**
     * Send doctor availability notification
     */
    public function sendDoctorAvailabilityNotification($doctor, $patients)
    {
        foreach ($patients as $patient) {
            $this->sendNotification([
                'notification_id' => 'doctor_available_' . $doctor->id . '_' . $patient->user->id,
                'user_id' => $patient->user->id,
                'email' => $patient->user->email,
                'phone' => $patient->user->phone,
                'template_id' => 'doctor_available',
                'merge_tags' => [
                    'patient_name' => $patient->user->name,
                    'doctor_name' => $doctor->name,
                    'specialization' => $doctor->specializations[0] ?? 'General Practice',
                ],
                'channels' => ['inApp', 'push'],
                'custom_data' => [
                    'doctor_id' => $doctor->id,
                    'type' => 'doctor_available',
                    'action_url' => route('mobile.auth.appointment')
                ]
            ]);
        }
    }

    /**
     * Get user notifications
     */
    public function getUserNotifications($userId, $limit = 20)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/users/' . $userId . '/notifications', [
                'limit' => $limit,
                'offset' => 0
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Failed to get user notifications: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId, $userId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->patch($this->baseUrl . '/notifications/' . $notificationId . '/read', [
                'userId' => $userId
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to mark notification as read: ' . $e->getMessage());
            return false;
        }
    }
}
