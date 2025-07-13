<?php

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
    Route::get('/video-call/prejoin/{appointmentId}', [App\Http\Controllers\VideoCallController::class, 'prejoin'])->name('video-call.prejoin');
    Route::get('/video-call/consultation/{appointmentId}', [App\Http\Controllers\VideoCallController::class, 'consultation'])->name('video-call.consultation');

    // Health check endpoint for prejoin connection testing
    Route::get('/api/health-check', [App\Http\Controllers\VideoCallController::class, 'healthCheck'])->name('api.health-check');
});

// Public health check endpoint (fallback)
Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Service is running',
        'timestamp' => now()->toISOString(),
        'service' => 'dr-fintan-medical-appointment'
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
            'message' => 'Redis/Valkey is properly configured!'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
});

// Test Daily.co integration
Route::get('/test-daily', function () {
    try {
        $apiKey = env('DAILY_API_KEY');
        $domain = env('DAILY_DOMAIN');

        if (!$apiKey || !$domain) {
            return response()->json([
                'status' => 'error',
                'message' => 'Daily.co API key or domain not configured'
            ]);
        }

        // Test creating a room
        $roomName = 'test-room-' . time();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json'
        ])->post('https://api.daily.co/v1/rooms', [
            'name' => $roomName,
            'properties' => [
                'max_participants' => 2,
                'enable_chat' => true,
                'enable_screenshare' => true,
                'start_video_off' => false,
                'start_audio_off' => false
            ]
        ]);

        if ($response->successful()) {
            $roomData = $response->json();
            return response()->json([
                'status' => 'success',
                'message' => 'Daily.co API is working!',
                'room_url' => $roomData['url'],
                'room_name' => $roomData['name'],
                'api_key_configured' => !empty($apiKey),
                'domain_configured' => $domain
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create Daily.co room',
                'error' => $response->body()
            ]);
        }

    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
});
//User Dashboard
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
       //delete Doctors
       Route::delete('{doctor}/delete', [App\Http\Controllers\admin\DoctorController::class, 'deleteDoctor'])
       ->name('delete');
        });

    // Patients Routes - All names will be prefixed with 'admin.patients.'
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\PatientController::class, 'index'])->name('index');
        Route::get('/{patient}', [App\Http\Controllers\admin\PatientController::class, 'show'])->name('show');
        Route::get('/{patient}/stats', [App\Http\Controllers\admin\PatientController::class, 'getAppointmentStats'])->name('stats'); // New route
       //delete Patient
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
    
});