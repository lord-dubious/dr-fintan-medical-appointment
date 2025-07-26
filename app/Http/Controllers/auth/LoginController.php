<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Get remember me option
        $remember = $request->boolean('remember');

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            // Authentication successful
            $user = Auth::user();

            // Check user role and redirect accordingly
            if ($user->role == 'patient') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => route('patient.dashboard'), // Use route helper
                ]);
            } elseif ($user->role === 'admin') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => route('admin.dashboard'),
                ]);
            } elseif ($user->role === 'doctor') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => route('doctor.dashboard'),
                ]);
            }

        } else {
            // Authentication failed
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }
    }

    // Register page
    public function register()
    {
        return view('auth.register');
    }

    public function mobileLogin()
    {
        return view('mobile.auth.login');
    }

    public function mobileRegister()
    {
        return view('mobile.auth.register');
    }

    // Logout function
    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/');
    }
}
