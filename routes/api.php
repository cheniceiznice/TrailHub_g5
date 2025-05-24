<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CylendarController;         // Google Calendar Controller
use App\Http\Controllers\SynDriveController;        // Google Drive Controller
use App\Http\Controllers\MyleBookController;        // Dictionary Controller
use App\Http\Controllers\NikaTalkController;        // Slack Controller
use App\Http\Controllers\JatrAIlController;         // OpenAI Controller
use App\Http\Middleware\ValidateGatewaySecret;     // Include the middleware

// Apply ValidateGatewaySecret middleware to all routes that need the gateway secret
Route::middleware([ValidateGatewaySecret::class])->group(function () {
    // Syn Archive (Google Drive)
    Route::post('/SynDrive/upload', [SynDriveController::class, 'uploadFile']);

    // Cylendar (Google Calendar)
    Route::get('/cylendar/event', [CylendarController::class, 'getEvent']);
    Route::get('/cylendar/event/{eventId}', [CylendarController::class, 'getEventById']);
    Route::post('/cylendar/event', [CylendarController::class, 'createEvent']);
    Route::put('/cylendar/event/{eventId}', [CylendarController::class, 'updateEvent']);
    Route::delete('/cylendar/event/{eventId}', [CylendarController::class, 'deleteEvent']);

    // Myle Book (Merriam-Webster Dictionary)
    Route::get('/myle-book/define', [MyleBookController::class, 'define']);

    // JatrAIl (OpenAI Chat)
    Route::post('/jatrail/chat', [JatrAIlController::class, 'chat']);
});

// Slack Routes (NikaTalkController)
Route::middleware([ValidateGatewaySecret::class])->prefix('nika-talk')->group(function () {
    Route::post('send', [NikaTalkController::class, 'sendMessage']);
    Route::get('messages', [NikaTalkController::class, 'getMessages']);
    Route::post('update', [NikaTalkController::class, 'updateMessage']);
    Route::post('delete', [NikaTalkController::class, 'deleteMessage']);
});
