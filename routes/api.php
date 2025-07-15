<?php

use App\Http\Controllers\VideoCallController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Daily.co Video Call Routes - Secured with authentication and CSRF
Route::middleware(['auth', 'web'])->group(function () {
    Route::post('/create-room', [VideoCallController::class, 'createRoom']);
    Route::get('/recording/{meetingId}', [VideoCallController::class, 'getRecording']);
    Route::get('/recording', [VideoCallController::class, 'listRecordings']);
    Route::post('/recording/start', [VideoCallController::class, 'startRecording']);
    Route::post('/recording/stop', [VideoCallController::class, 'stopRecording']);
    Route::post('/end-call', [VideoCallController::class, 'endCall']);
});
