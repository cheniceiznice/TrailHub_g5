<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\UploadController;

Route::post('/drive/upload', [UploadController::class, 'upload']);
Route::post('/drive/google-upload', [GoogleDriveController::class, 'uploadFile']);

