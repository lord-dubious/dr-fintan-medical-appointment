<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getMobileNotifications()
    {
        $user = Auth::user();
        $notifications = [];

        // Get user-specific notifications based on role
        if ($user->role === 'admin') {
            $notifications = $this->getAdminNotifications();
        } elseif ($user->role === 'doctor') {
            $notifications = $this->getDoctorNotifications();
        } elseif ($user->role === 'patient') {
            $notifications = $this->getPatientNotifications();
        }

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => count(array_filter($notifications, function($n) { return !$n['read']; }))
        ]);
    }

    private function getAdminNotifications()
    {
        // Get pending appointments and other admin notifications
        $pendingCount = \App\Models\Appointment::where('status', 'pending')->count();
        
        $notifications = [];
        
        if ($pendingCount > 0) {
            $notifications[] = [
                'id' => 'pending_appointments',
                'title' => 'Pending Appointments',
                'message' => "You have {$pendingCount} pending appointment" . ($pendingCount > 1 ? 's' : '') . " to review",
                'type' => 'appointment',
                'time' => 'Now',
                'read' => false,
                'action_url' => route('mobile.admin.appointments')
            ];
        }

        return $notifications;
    }

    private function getDoctorNotifications()
    {
        $user = Auth::user();
        $doctor = $user->doctor;
        
        // Get today's appointments
        $todayAppointments = $doctor->appointments()
            ->whereDate('appointment_date', today())
            ->where('status', 'confirmed')
            ->count();

        $notifications = [];
        
        if ($todayAppointments > 0) {
            $notifications[] = [
                'id' => 'today_appointments',
                'title' => "Today's Schedule",
                'message' => "You have {$todayAppointments} appointment" . ($todayAppointments > 1 ? 's' : '') . " scheduled for today",
                'type' => 'schedule',
                'time' => 'Today',
                'read' => false,
                'action_url' => route('mobile.doctor.appointments')
            ];
        }

        return $notifications;
    }

    private function getPatientNotifications()
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        // Get upcoming appointments
        $upcomingAppointments = $patient->appointments()
            ->where('appointment_date', '>=', today())
            ->where('status', 'confirmed')
            ->count();

        $notifications = [];
        
        if ($upcomingAppointments > 0) {
            $notifications[] = [
                'id' => 'upcoming_appointments',
                'title' => 'Upcoming Appointments',
                'message' => "You have {$upcomingAppointments} upcoming appointment" . ($upcomingAppointments > 1 ? 's' : ''),
                'type' => 'appointment',
                'time' => 'Soon',
                'read' => false,
                'action_url' => route('mobile.user.appointments')
            ];
        }

        return $notifications;
    }

    public function subscribeToPush(Request $request)
    {
        $request->validate([
            'subscription' => 'required|array',
            'subscription.endpoint' => 'required|string',
            'subscription.keys' => 'required|array',
            'subscription.keys.p256dh' => 'required|string',
            'subscription.keys.auth' => 'required|string',
        ]);

        $user = $request->user();
        
        // Store push subscription in user preferences
        $user->update([
            'push_subscription' => json_encode($request->subscription)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Push notification subscription saved successfully'
        ]);
    }
}
