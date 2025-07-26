<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        return view('doctor.profile.index', compact('user', 'doctor'));
    }

    public function updateBasicInfo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->update($request->only([
            'name', 'email', 'phone', 'address', 'bio',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Basic information updated successfully!',
        ]);
    }

    public function updateDoctorInfo(Request $request)
    {
        $doctor = Auth::user()->doctor;

        $request->validate([
            'specializations' => 'nullable|array',
            'specializations.*' => 'string|max:255',
            'qualifications' => 'nullable|array',
            'qualifications.*' => 'string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'license_number' => 'nullable|string|max:255',
            'consultation_fee' => 'nullable|numeric|min:0',
            'languages' => 'nullable|array',
            'languages.*' => 'string|max:255',
        ]);

        $doctor->update($request->only([
            'specializations', 'qualifications', 'experience_years', 'license_number', 'consultation_fee', 'languages',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Professional information updated successfully!',
        ]);
    }

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $path = $request->file('profile_image')->store('profile-images', 'public');
        $user->update(['profile_image' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Profile image updated successfully!',
            'image_url' => asset('storage/'.$path),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!',
        ]);
    }

    public function updateAvailability(Request $request)
    {
        $doctor = Auth::user()->doctor;

        $request->validate([
            'working_hours' => 'nullable|array',
        ]);

        $doctor->update(['working_hours' => $request->working_hours]);

        return response()->json([
            'success' => true,
            'message' => 'Working hours updated successfully!',
        ]);
    }

    public function getProfileData()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        return response()->json([
            'user' => $user,
            'doctor' => $doctor,
            'profile_image_url' => $user->profile_image ? asset('storage/'.$user->profile_image) : null,
        ]);
    }

    public function mobileIndex()
    {
        $user = Auth::user();
        $doctor = $user->doctor;
        
        // Get basic stats for mobile view
        $stats = [
            'total_appointments' => $doctor->appointments()->count(),
            'completed_appointments' => $doctor->appointments()->where('status', 'completed')->count(),
            'pending_appointments' => $doctor->appointments()->where('status', 'pending')->count(),
        ];

        return view('mobile.doctor.profile', compact('user', 'doctor', 'stats'));
    }
}
