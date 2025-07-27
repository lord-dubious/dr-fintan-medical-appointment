<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the patient profile page
     */
    public function index()
    {
        $user = Auth::user();
        $patient = $user->patient;

        return view('user.profile.index', compact('user', 'patient'));
    }

    /**
     * Update basic user information
     */
    public function updateBasicInfo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->update($request->only([
            'name', 'email', 'phone', 'address', 'date_of_birth', 'bio',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Basic information updated successfully!',
        ]);
    }

    /**
     * Update patient-specific information
     */
    public function updatePatientInfo(Request $request)
    {
        $user = Auth::user();
        $patient = $user->patient;

        $request->validate([
            'blood_type' => 'nullable|string|max:10',
            'allergies' => 'nullable|string|max:1000',
            'current_medications' => 'nullable|string|max:1000',
            'emergency_contact' => 'nullable|array',
            'emergency_contact.name' => 'nullable|string|max:255',
            'emergency_contact.phone' => 'nullable|string|max:20',
            'emergency_contact.relationship' => 'nullable|string|max:100',
            'medical_history' => 'nullable|array',
            'insurance_info' => 'nullable|array',
            'preferences' => 'nullable|array',
        ]);

        $patient->update($request->only([
            'blood_type', 'allergies', 'current_medications',
            'emergency_contact', 'medical_history', 'insurance_info', 'preferences',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Medical information updated successfully!',
        ]);
    }

    /**
     * Update profile image
     */
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new image
        $imagePath = $request->file('profile_image')->store('profile-images', 'public');

        $user->update(['profile_image' => $imagePath]);

        return response()->json([
            'success' => true,
            'message' => 'Profile image updated successfully!',
            'image_url' => asset('storage/'.$imagePath),
        ]);
    }

    /**
     * Update password
     */
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

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!',
        ]);
    }

    /**
     * Get profile data as JSON
     */
    public function getProfileData()
    {
        $user = Auth::user();
        $patient = $user->patient;

        return response()->json([
            'user' => $user,
            'patient' => $patient,
            'profile_image_url' => $user->profile_image ? asset('storage/'.$user->profile_image) : null,
        ]);
    }

    public function mobileIndex()
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        // Get basic stats for mobile view
        $stats = [
            'total_appointments' => $patient->appointments()->count(),
            'completed_appointments' => $patient->appointments()->where('status', 'completed')->count(),
            'upcoming_appointments' => $patient->appointments()->where('status', 'confirmed')->where('appointment_date', '>=', now())->count(),
        ];

        return view('mobile.user.profile', compact('user', 'patient', 'stats'));
    }
}
