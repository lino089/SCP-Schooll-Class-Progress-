<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SchoolClassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AcademicSettingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/academic-settings', [AcademicSettingController::class, 'index'])
        ->middleware('can:is_waka');

    Route::get('/classes', [SchoolClassController::class, 'index']);
});