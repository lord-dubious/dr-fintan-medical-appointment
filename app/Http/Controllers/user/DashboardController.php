<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $patient = $user->patient;

        $appointmentStats = [
            'total' => $patient->totalAppointments(),
            'active' => $patient->activeAppointments(),
            'expired' => $patient->expiredAppointments(),
            'today' => $patient->todaysAppointments(),
        ];

        return view('user.dashboard', compact('user', 'patient', 'appointmentStats'));
    }

    public function mobileIndex()
    {
        $user = Auth::user();
        $patient = $user->patient;

        $appointmentStats = [
            'total' => $patient->totalAppointments(),
            'active' => $patient->activeAppointments(),
            'expired' => $patient->expiredAppointments(),
            'today' => $patient->todaysAppointments(),
        ];

        return view('mobile.user.dashboard', compact('user', 'patient', 'appointmentStats'));
    }

    public function getMobileStats()
    {
        $user = Auth::user();
        $patient = $user->patient;

        $stats = [
            'totalAppointments' => $patient->totalAppointments(),
            'activeAppointments' => $patient->activeAppointments(),
            'expiredAppointments' => $patient->expiredAppointments(),
            'todayAppointments' => $patient->todaysAppointments(),
        ];

        return response()->json($stats);
    }
}
