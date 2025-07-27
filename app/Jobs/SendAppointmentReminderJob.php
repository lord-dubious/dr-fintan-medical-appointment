<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Services\NotificationsApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAppointmentReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $appointment;
    protected $reminderType;

    /**
     * Create a new job instance.
     */
    public function __construct(Appointment $appointment, string $reminderType = '24h')
    {
        $this->appointment = $appointment;
        $this->reminderType = $reminderType;
    }

    /**
     * Execute the job.
     */
    public function handle(NotificationsApiService $notificationService): void
    {
        try {
            // Check if appointment is still valid
            if ($this->appointment->status === 'cancelled' || $this->appointment->status === 'completed') {
                Log::info('Skipping reminder for cancelled/completed appointment', [
                    'appointment_id' => $this->appointment->id,
                    'status' => $this->appointment->status
                ]);
                return;
            }

            $patient = $this->appointment->patient;
            $doctor = $this->appointment->doctor;

            // Determine template based on reminder type
            $templateId = match($this->reminderType) {
                '24h' => 'appointment_reminder_24h',
                '2h' => 'appointment_reminder_2h',
                '30m' => 'appointment_reminder_30m',
                default => 'appointment_reminder_24h'
            };

            $reminderTime = match($this->reminderType) {
                '24h' => '24 hours',
                '2h' => '2 hours', 
                '30m' => '30 minutes',
                default => '24 hours'
            };

            // Send reminder notification
            $result = $notificationService->sendAppointmentReminder($this->appointment, $templateId, $reminderTime);

            if ($result) {
                Log::info('Appointment reminder sent successfully', [
                    'appointment_id' => $this->appointment->id,
                    'patient_id' => $patient->id,
                    'reminder_type' => $this->reminderType
                ]);
            } else {
                Log::error('Failed to send appointment reminder', [
                    'appointment_id' => $this->appointment->id,
                    'patient_id' => $patient->id,
                    'reminder_type' => $this->reminderType
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error in SendAppointmentReminderJob: ' . $e->getMessage(), [
                'appointment_id' => $this->appointment->id,
                'reminder_type' => $this->reminderType,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw to mark job as failed
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('SendAppointmentReminderJob failed', [
            'appointment_id' => $this->appointment->id,
            'reminder_type' => $this->reminderType,
            'error' => $exception->getMessage()
        ]);
    }
}