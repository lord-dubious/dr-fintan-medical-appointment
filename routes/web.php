<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\frontend\HomeController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\frontend\HomeController::class, 'contact'])->name('contact');
Route::get('/appointment', [App\Http\Controllers\auth\AppointmentController::class, 'index'])->name('appointment');
Route::post('/appointment/store', [App\Http\Controllers\auth\AppointmentController::class, 'store'])->name('appointment.store');
Route::post('/appointment/payment/initialize', [App\Http\Controllers\auth\AppointmentController::class, 'initializePayment'])->name('appointment.payment.initialize');
Route::get('/appointment/payment/callback', [App\Http\Controllers\auth\AppointmentController::class, 'paymentCallback'])->name('appointment.payment.callback');
Route::post('/paystack/webhook', [App\Http\Controllers\auth\AppointmentController::class, 'paystackWebhook'])->name('paystack.webhook');
Route::get('/login', [App\Http\Controllers\auth\LoginController::class, 'index'])->name('login');
Route::post('/login/auth', [App\Http\Controllers\auth\LoginController::class, 'login'])->name('login.auth');
Route::get('/register', [App\Http\Controllers\auth\LoginController::class, 'register'])->name('register');
Route::get('/logout', [App\Http\Controllers\auth\LoginController::class, 'logout'])->name('logout');

// Video Call Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/video-call/{appointmentId}', [App\Http\Controllers\VideoCallController::class, 'consultation'])->name('video-call.consultation');
    Route::post('/video-call/room/{appointmentId}', [App\Http\Controllers\VideoCallController::class, 'createRoom'])->name('video-call.room');

    // Health check endpoint
    Route::get('/api/health-check', [App\Http\Controllers\VideoCallController::class, 'healthCheck'])->name('api.health-check');

    // Debug route (temporary)
    Route::get('/debug/user-info', function () {
        $user = Auth::user();

        return response()->json([
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_email' => $user->email,
            'has_patient' => $user->patient ? true : false,
            'has_doctor' => $user->doctor ? true : false,
            'patient_id' => $user->patient ? $user->patient->id : null,
            'doctor_id' => $user->doctor ? $user->doctor->id : null,
        ]);
    });
});

// User Profile Routes
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [App\Http\Controllers\user\ProfileController::class, 'index'])->name('index');
    Route::post('/basic-info', [App\Http\Controllers\user\ProfileController::class, 'updateBasicInfo'])->name('update-basic');
    Route::post('/patient-info', [App\Http\Controllers\user\ProfileController::class, 'updatePatientInfo'])->name('update-patient');
    Route::post('/profile-image', [App\Http\Controllers\user\ProfileController::class, 'updateProfileImage'])->name('update-image');
    Route::post('/password', [App\Http\Controllers\user\ProfileController::class, 'updatePassword'])->name('update-password');
    Route::get('/data', [App\Http\Controllers\user\ProfileController::class, 'getProfileData'])->name('data');
});

// Doctor Profile Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor/profile')->name('doctor.profile.')->group(function () {
    Route::get('/', [App\Http\Controllers\doctor\ProfileController::class, 'index'])->name('index');
    Route::post('/basic-info', [App\Http\Controllers\doctor\ProfileController::class, 'updateBasicInfo'])->name('update-basic');
    Route::post('/doctor-info', [App\Http\Controllers\doctor\ProfileController::class, 'updateDoctorInfo'])->name('update-doctor');
    Route::post('/profile-image', [App\Http\Controllers\doctor\ProfileController::class, 'updateProfileImage'])->name('update-image');
    Route::post('/password', [App\Http\Controllers\doctor\ProfileController::class, 'updatePassword'])->name('update-password');
    Route::post('/availability', [App\Http\Controllers\doctor\ProfileController::class, 'updateAvailability'])->name('update-availability');
    Route::get('/data', [App\Http\Controllers\doctor\ProfileController::class, 'getProfileData'])->name('data');
});

// Public health check endpoint (fallback)
Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Service is running',
        'timestamp' => now()->toISOString(),
        'service' => 'dr-fintan-medical-appointment',
    ]);
})->name('health-check');
Route::get('/check-doctor-availability', [App\Http\Controllers\auth\AppointmentController::class, 'checkAvailability'])
    ->name('check.doctor.availability');

// Test Redis connection
Route::get('/test-redis', function () {
    try {
        // Test cache
        Cache::put('test_key', 'Redis is working with Laravel!', 60);
        $cached_value = Cache::get('test_key');

        // Test direct Redis
        $redis = Redis::connection();
        $redis->set('direct_test', 'Direct Redis connection works!');
        $direct_value = $redis->get('direct_test');

        return response()->json([
            'status' => 'success',
            'cache_test' => $cached_value,
            'direct_redis_test' => $direct_value,
            'message' => 'Redis/Valkey is properly configured!',
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ]);
    }
});

// Test Daily.co integration
Route::get('/test-daily', function () {
    try {
        $apiKey = env('DAILY_API_KEY');
        $domain = env('DAILY_DOMAIN');

        if (! $apiKey || ! $domain) {
            return response()->json([
                'status' => 'error',
                'message' => 'Daily.co API key or domain not configured',
            ]);
        }

        // Test creating a room
        $roomName = 'test-room-'.time();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.daily.co/v1/rooms', [
            'name' => $roomName,
            'properties' => [
                'max_participants' => 2,
                'enable_chat' => true,
                'enable_screenshare' => true,
                'start_video_off' => false,
                'start_audio_off' => false,
            ],
        ]);

        if ($response->successful()) {
            $roomData = $response->json();

            return response()->json([
                'status' => 'success',
                'message' => 'Daily.co API is working!',
                'room_url' => $roomData['url'],
                'room_name' => $roomData['name'],
                'api_key_configured' => ! empty($apiKey),
                'domain_configured' => $domain,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create Daily.co room',
                'error' => $response->body(),
            ]);
        }

    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ]);
    }
});
// User Dashboard
Route::middleware(['auth', 'patient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\user\DashboardController::class, 'index'])->name('patient.dashboard');
    Route::get('/appointment', [App\Http\Controllers\user\AppointmentController::class, 'index'])->name('patient.appointment');
    Route::get('/book_appointment', [App\Http\Controllers\user\AppointmentController::class, 'book_appointment'])->name('patient.book_appointment');
    Route::post('/book_appointment/store', [App\Http\Controllers\user\AppointmentController::class, 'save_Appointment'])->name('patient.book_appointment.store');
});

Route::middleware(['auth', 'doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\doctor\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointment', [App\Http\Controllers\doctor\AppointmentController::class, 'index'])->name('appointment');
    Route::put('/appointments/{appointment}/status', [App\Http\Controllers\doctor\AppointmentController::class, 'updateStatus'])->name('update.status');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard - Now correctly named 'admin.dashboard'
    Route::get('/dashboard', [App\Http\Controllers\admin\DashboardController::class, 'index'])->name('dashboard');

    // Login as Doctor
    Route::post('doctors/{doctor}/login-as', [App\Http\Controllers\admin\DoctorController::class, 'loginAsDoctor'])->name('login-as-doctor');

    // Doctors Routes - All names will be prefixed with 'admin.doctors.'
    Route::prefix('doctors')->name('doctors.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\DoctorController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\admin\DoctorController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\admin\DoctorController::class, 'store'])->name('store');
        Route::get('/{doctor}', [App\Http\Controllers\admin\DoctorController::class, 'show'])->name('show');
        Route::get('/{doctor}/edit', [App\Http\Controllers\admin\DoctorController::class, 'edit'])->name('edit');
        Route::put('/{doctor}', [App\Http\Controllers\admin\DoctorController::class, 'update'])->name('update');
        Route::delete('/{doctor}', [App\Http\Controllers\admin\DoctorController::class, 'destroy'])->name('destroy');

        // Add the stats route while maintaining your structure
        Route::get('/{doctor}/stats', [App\Http\Controllers\admin\DoctorController::class, 'getDoctorStats'])
            ->name('stats');
        // delete Doctors
        Route::delete('{doctor}/delete', [App\Http\Controllers\admin\DoctorController::class, 'deleteDoctor'])
            ->name('delete');

        // Login as Doctor
        Route::post('{doctor}/login-as', [App\Http\Controllers\admin\DoctorController::class, 'loginAsDoctor'])
            ->name('login-as-doctor');
    });

    // Patients Routes - All names will be prefixed with 'admin.patients.'
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\PatientController::class, 'index'])->name('index');
        Route::get('/{patient}', [App\Http\Controllers\admin\PatientController::class, 'show'])->name('show');
        Route::get('/{patient}/stats', [App\Http\Controllers\admin\PatientController::class, 'getAppointmentStats'])->name('stats'); // New route
        // delete Patient
        Route::delete('{patient}/delete', [App\Http\Controllers\admin\PatientController::class, 'deletePatient'])
            ->name('delete');

    });
    // Appointments Routes - All names will be prefixed with 'admin.appointments.'
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\AppointmentController::class, 'index'])->name('index');
        Route::get('/pending', [App\Http\Controllers\admin\AppointmentController::class, 'pending'])->name('pending');
        Route::get('/{appointment}', [App\Http\Controllers\admin\AppointmentController::class, 'show'])->name('show');
        Route::put('/{appointment}/status', [App\Http\Controllers\admin\AppointmentController::class, 'updateStatus'])->name('update.status');
        Route::delete('/{appointment}', [App\Http\Controllers\admin\AppointmentController::class, 'destroy'])->name('destroy');
        Route::get('/{appointment}/message', [App\Http\Controllers\admin\AppointmentController::class, 'showMessage'])->name('message');
    });

    // Content Management Routes
    Route::prefix('content')->name('content.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\ContentController::class, 'index'])->name('index');
        Route::get('/page/{page}', [App\Http\Controllers\admin\ContentController::class, 'editPage'])->name('edit-page');
        Route::post('/page/{page}', [App\Http\Controllers\admin\ContentController::class, 'updatePageContent'])->name('update-page');
        Route::get('/page/{page}/data', [App\Http\Controllers\admin\ContentController::class, 'getPageContent'])->name('get-page');
        Route::delete('/page/{page}', [App\Http\Controllers\admin\ContentController::class, 'deletePageContent'])->name('delete-content');
    });

    // Settings Management Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\SettingsController::class, 'index'])->name('index');
        Route::post('/update', [App\Http\Controllers\admin\SettingsController::class, 'update'])->name('update');
        Route::post('/upload-image', [App\Http\Controllers\admin\SettingsController::class, 'uploadImage'])->name('upload-image');
        Route::get('/get/{key}', [App\Http\Controllers\admin\SettingsController::class, 'getSetting'])->name('get');
        Route::post('/initialize', [App\Http\Controllers\admin\SettingsController::class, 'initializeDefaults'])->name('initialize');
        Route::post('/reset', [App\Http\Controllers\admin\SettingsController::class, 'resetToDefaults'])->name('reset');
    });

    // Media Library Routes
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\MediaController::class, 'index'])->name('index');
        Route::post('/upload', [App\Http\Controllers\admin\MediaController::class, 'upload'])->name('upload');
        Route::put('/{media}', [App\Http\Controllers\admin\MediaController::class, 'update'])->name('update');
        Route::delete('/{media}', [App\Http\Controllers\admin\MediaController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [App\Http\Controllers\admin\MediaController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/picker', [App\Http\Controllers\admin\MediaController::class, 'picker'])->name('picker');
        Route::get('/search', [App\Http\Controllers\admin\MediaController::class, 'search'])->name('search');
    });

});
