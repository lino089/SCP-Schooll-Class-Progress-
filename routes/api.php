<?php

use App\Http\Controllers\API\AiQuizController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\APi\JournalController;
use App\Http\Controllers\API\LeaveRequestController;
use App\Http\Controllers\API\QuizSubmissionController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\SchoolClassController;
use App\Http\Controllers\API\StudentController;
use App\Models\QuizSubmission;
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

    Route::get('/students', [StudentController::class, 'index']);

    Route::post('/schedules', [ScheduleController::class, 'store'])
        ->middleware('can:is_guru');

    Route::get('/schedules', [ScheduleController::class, 'index']);

    Route::post('/journals', [JournalController::class, 'store']);

    Route::post('/leave-requests', [LeaveRequestController::class, 'store']);

    Route::patch('/leave-requests/{id}/status', [LeaveRequestController::class, 'updateStatus']);

    Route::get('/leave-requests', [LeaveRequestController::class, 'index']);

    Route::post('/quizzes', [AiQuizController::class, 'store']);

    Route::post('/quiz-submissions', [QuizSubmissionController::class, 'store']);
});