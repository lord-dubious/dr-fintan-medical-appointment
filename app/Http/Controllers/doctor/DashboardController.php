<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        $appointmentStats = [
            'total' => $doctor->appointments()->count(),
            'active' => $doctor->activeAppointments(),
            'expired' => $doctor->expiredAppointments(),
            'today' => $doctor->todaysAppointments(),
        ];

        return view('doctor.dashboard', compact('user', 'doctor', 'appointmentStats'));
    }

    public function mobileIndex()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        $appointmentStats = [
            'total' => $doctor->appointments()->count(),
            'active' => $doctor->activeAppointments(),
            'expired' => $doctor->expiredAppointments(),
            'today' => $doctor->todaysAppointments(),
        ];

        return view('mobile.doctor.dashboard', compact('user', 'doctor', 'appointmentStats'));
    }

    public function getMobileStats()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        $stats = [
            'totalAppointments' => $doctor->appointments()->count(),
            'activeAppointments' => $doctor->activeAppointments(),
            'expiredAppointments' => $doctor->expiredAppointments(),
            'todayAppointments' => $doctor->todaysAppointments(),
        ];

        return response()->json($stats);
    }
}
