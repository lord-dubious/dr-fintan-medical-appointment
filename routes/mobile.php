<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\AppointmentController as AuthAppointmentController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\admin\PatientController as AdminPatientController;
use App\Http\Controllers\admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\user\DashboardController as UserDashboardController;

/*
|--------------------------------------------------------------------------
| Mobile Routes
|--------------------------------------------------------------------------
|
| These routes are specifically for mobile views and will be loaded
| when the mobile detection middleware identifies a mobile device.
|
*/

// Mobile Frontend Routes
Route::prefix('mobile')->name('mobile.')->group(function () {
    
    // Public mobile pages
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    
    // Mobile Authentication Routes
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/login', [LoginController::class, 'mobileLogin'])->name('login');
        Route::get('/register', [LoginController::class, 'mobileRegister'])->name('register');
        Route::get('/appointment', [AuthAppointmentController::class, 'mobileIndex'])->name('appointment');
        Route::post('/appointment/store', [AuthAppointmentController::class, 'store'])->name('appointment.store');
        Route::post('/appointment/payment/initialize', [AuthAppointmentController::class, 'initializePayment'])->name('appointment.payment.initialize');
        Route::get('/appointment/payment/callback', [AuthAppointmentController::class, 'paymentCallback'])->name('appointment.payment.callback');
    });
    
    // Mobile Admin Routes (Protected)
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'mobileIndex'])->name('dashboard');
        Route::get('/appointments', [AdminAppointmentController::class, 'mobileIndex'])->name('appointments');
        Route::get('/patients', [AdminPatientController::class, 'mobileIndex'])->name('patients');
        Route::get('/doctors', [AdminDoctorController::class, 'mobileIndex'])->name('doctors');
        Route::get('/content', [App\Http\Controllers\admin\ContentController::class, 'mobileIndex'])->name('content');
        Route::get('/media', [App\Http\Controllers\admin\MediaController::class, 'mobileIndex'])->name('media');
        Route::get('/settings', [App\Http\Controllers\admin\SettingsController::class, 'mobileIndex'])->name('settings');
    });
    
    // Mobile Doctor Routes (Protected)
    Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'doctor'])->group(function () {
        Route::get('/dashboard', [DoctorDashboardController::class, 'mobileIndex'])->name('dashboard');
        Route::get('/appointments', [App\Http\Controllers\doctor\AppointmentController::class, 'mobileIndex'])->name('appointments');
        Route::get('/profile', [App\Http\Controllers\doctor\ProfileController::class, 'mobileIndex'])->name('profile');
    });
    
    // Mobile User/Patient Routes (Protected)
    Route::prefix('user')->name('user.')->middleware(['auth', 'patient'])->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'mobileIndex'])->name('dashboard');
        Route::get('/appointments', [App\Http\Controllers\user\AppointmentController::class, 'mobileIndex'])->name('appointments');
        Route::get('/book-appointment', [App\Http\Controllers\user\AppointmentController::class, 'mobileBookAppointment'])->name('book_appointment');
        Route::get('/profile', [App\Http\Controllers\user\ProfileController::class, 'mobileIndex'])->name('profile');
    });
});

// Mobile API Routes for AJAX calls
Route::prefix('mobile-api')->name('mobile.api.')->group(function () {
    
    // Appointment booking API
    Route::post('/appointments/book', [AuthAppointmentController::class, 'store'])->name('appointments.book');
    
    // Get available time slots
    Route::get('/appointments/slots/{doctorId}/{date}', [AuthAppointmentController::class, 'getAvailableSlots'])->name('appointments.slots');
    
    // Check doctor availability
    Route::get('/appointments/availability', [AuthAppointmentController::class, 'checkAvailability'])->name('appointments.availability');
    
    // Mobile dashboard stats
    Route::get('/admin/stats', [AdminDashboardController::class, 'getMobileStats'])->middleware(['auth', 'admin'])->name('admin.stats');
    
    // Mobile doctor stats
    Route::get('/doctor/stats', [DoctorDashboardController::class, 'getMobileStats'])->middleware(['auth', 'doctor'])->name('doctor.stats');
    
    // Mobile patient stats
    Route::get('/user/stats', [UserDashboardController::class, 'getMobileStats'])->middleware(['auth', 'patient'])->name('user.stats');
    
    // Mobile notifications
    Route::get('/notifications', [App\Http\Controllers\API\NotificationController::class, 'getMobileNotifications'])->middleware('auth')->name('notifications');
    
    // Push notification subscription
    Route::post('/notifications/subscribe', [App\Http\Controllers\API\NotificationController::class, 'subscribeToPush'])->middleware('auth')->name('notifications.subscribe');
});