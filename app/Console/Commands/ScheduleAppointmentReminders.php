<?php

namespace App\Console\Commands;

use App\Jobs\SendAppointmentReminderJob;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScheduleAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'appointments:schedule-reminders';

    /**
     * The console command description.
     */
    protected $description = 'Schedule appointment reminder notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scheduling appointment reminders...');

        // Get appointments that need reminders
        $appointments = Appointment::where('status', 'confirmed')
            ->where('appointment_date', '>=', Carbon::today())
            ->where('appointment_date', '<=', Carbon::today()->addDays(2))
            ->get();

        $scheduled = 0;

        foreach ($appointments as $appointment) {
            $appointmentDateTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);
            
            // Schedule 24-hour reminder
            $reminder24h = $appointmentDateTime->copy()->subHours(24);
            if ($reminder24h->isFuture() && $reminder24h->diffInHours(now()) <= 25) {
                SendAppointmentReminderJob::dispatch($appointment, '24h')
                    ->delay($reminder24h);
                $scheduled++;
                $this->line("Scheduled 24h reminder for appointment {$appointment->id}");
            }

            // Schedule 2-hour reminder
            $reminder2h = $appointmentDateTime->copy()->subHours(2);
            if ($reminder2h->isFuture() && $reminder2h->diffInHours(now()) <= 3) {
                SendAppointmentReminderJob::dispatch($appointment, '2h')
                    ->delay($reminder2h);
                $scheduled++;
                $this->line("Scheduled 2h reminder for appointment {$appointment->id}");
            }

            // Schedule 30-minute reminder
            $reminder30m = $appointmentDateTime->copy()->subMinutes(30);
            if ($reminder30m->isFuture() && $reminder30m->diffInMinutes(now()) <= 60) {
                SendAppointmentReminderJob::dispatch($appointment, '30m')
                    ->delay($reminder30m);
                $scheduled++;
                $this->line("Scheduled 30m reminder for appointment {$appointment->id}");
            }
        }

        $this->info("Scheduled {$scheduled} appointment reminders for {$appointments->count()} appointments.");
        
        Log::info('Appointment reminders scheduled', [
            'appointments_processed' => $appointments->count(),
            'reminders_scheduled' => $scheduled
        ]);

        return Command::SUCCESS;
    }
}
