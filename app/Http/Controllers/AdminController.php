<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Allow admin to login as any doctor
     */
    public function loginAsDoctor(Request $request, Doctor $doctor)
    {
        // Check if current user is admin
        if (! Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Get the doctor's user account
        $doctorUser = $doctor->user;

        if (! $doctorUser) {
            return redirect()->back()->with('error', 'Doctor user account not found.');
        }

        // Store current admin user ID in session for later restoration
        session(['original_admin_id' => Auth::id()]);

        // Login as the doctor
        Auth::login($doctorUser);

        return redirect()->route('doctor.dashboard')->with('success', "You are now logged in as {$doctor->name}");
    }

    /**
     * Return to admin account from doctor account
     */
    public function returnToAdmin(Request $request)
    {
        $originalAdminId = session('original_admin_id');

        if (! $originalAdminId) {
            return redirect()->route('login')->with('error', 'No admin session found.');
        }

        $adminUser = User::find($originalAdminId);

        if (! $adminUser || $adminUser->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Admin account not found.');
        }

        // Clear the session
        session()->forget('original_admin_id');

        // Login back as admin
        Auth::login($adminUser);

        return redirect()->route('admin.dashboard')->with('success', 'Returned to admin account.');
    }
}
