<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VideoConsultationController;

// Daily.co Video Consultation Routes
Route::middleware('auth')->group(function () {
    Route::post('/consultation/create-room', [VideoConsultationController::class, 'createConsultationRoom']);
    Route::post('/consultation/get-room', [VideoConsultationController::class, 'getConsultationRoom']);
    Route::post('/consultation/create-audio', [VideoConsultationController::class, 'createAudioConsultation']);
    Route::post('/consultation/end', [VideoConsultationController::class, 'endConsultation']);
});