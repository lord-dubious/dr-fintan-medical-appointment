<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    //

    public function index()
    {
        $doctors = Doctor::withCount(['appointments as total_appointments',
            'appointments as pending_appointments' => function ($query) {
                $query->where('status', 'pending');
            },
            'appointments as active_appointments' => function ($query) {
                $query->where('status', 'confirmed')
                    ->where('appointment_date', '>=', now()->format('Y-m-d'));
            },
            'appointments as expired_appointments' => function ($query) {
                $query->where(function ($q) {
                    $q->where('status', 'confirmed')
                        ->where('appointment_date', '<', now()->format('Y-m-d'))
                        ->orWhere('status', 'expired');
                });
            }])
            ->latest()
            ->paginate(10);

        return view('admin.doctor', compact('doctors'));
    }

    public function getDoctorStats(Doctor $doctor)
    {
        $today = now()->format('Y-m-d');

        // Get all appointments for this patient
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        // Calculate counts
        $stats = [
            'total' => $appointments->count(),
            'pending' => $appointments->where('status', 'pending')->count(),
            'active' => $appointments->filter(function ($appointment) use ($today) {
                return $appointment->status === 'confirmed' &&
                       $appointment->appointment_date >= $today;
            })->count(),
            'expired' => $appointments->filter(function ($appointment) use ($today) {
                return ($appointment->status === 'confirmed' &&
                       $appointment->appointment_date < $today) ||
                       $appointment->status === 'expired';
            })->count(),
        ];

        return response()->json($stats);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        // Create user first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor',
        ]);

        // Then create doctor
        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
            'mobile' => $request->mobile,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor added successfully',
        ]);
    }

    public function deleteDoctor(Doctor $doctor)
    {

        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully!');
    }

    /**
     * Log in as the selected doctor.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAsDoctor(Doctor $doctor)
    {
        Auth::loginUsingId($doctor->user_id);

        return redirect()->route('doctor.dashboard');
    }

    public function mobileIndex()
    {
        $doctors = Doctor::withCount(['appointments as total_appointments',
            'appointments as pending_appointments' => function ($query) {
                $query->where('status', 'pending');
            },
            'appointments as active_appointments' => function ($query) {
                $query->where('status', 'confirmed')
                    ->where('appointment_date', '>=', now()->format('Y-m-d'));
            },
            'appointments as expired_appointments' => function ($query) {
                $query->where(function ($q) {
                    $q->where('status', 'confirmed')
                        ->where('appointment_date', '<', now()->format('Y-m-d'))
                        ->orWhere('status', 'expired');
                });
            }])
            ->latest()
            ->paginate(8);

        return view('mobile.admin.doctors', compact('doctors'));
    }
}
