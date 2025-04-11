<?php

use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\YearlyTargetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Puskesmas\DashboardController;
use App\Http\Controllers\Puskesmas\DmExaminationController;
use App\Http\Controllers\Puskesmas\HtExaminationController;
use App\Http\Controllers\Puskesmas\PatientController;
use App\Http\Controllers\Puskesmas\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    
    // Profile
    Route::post('/profile', [ProfileController::class, 'update']);
    
    // Admin routes
    Route::middleware('can:admin')->prefix('admin')->group(function () {
        // User management
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword']);
        
        // Yearly targets
        Route::get('/yearly-targets', [YearlyTargetController::class, 'index']);
        Route::post('/yearly-targets', [YearlyTargetController::class, 'store']);
        Route::get('/yearly-targets/{target}', [YearlyTargetController::class, 'show']);
        Route::put('/yearly-targets/{target}', [YearlyTargetController::class, 'update']);
        Route::delete('/yearly-targets/{target}', [YearlyTargetController::class, 'destroy']);
        
        // Statistics
        Route::get('/statistics', [StatisticsController::class, 'index']);
        Route::get('/statistics/export-pdf', [StatisticsController::class, 'exportPdf']);
        Route::get('/statistics/export-excel', [StatisticsController::class, 'exportExcel']);
    });
    
    // Puskesmas routes
    Route::middleware('can:puskesmas')->prefix('puskesmas')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);
        
        // Patients
        Route::get('/patients', [PatientController::class, 'index']);
        Route::post('/patients', [PatientController::class, 'store']);
        Route::get('/patients/{patient}', [PatientController::class, 'show']);
        Route::put('/patients/{patient}', [PatientController::class, 'update']);
        Route::delete('/patients/{patient}', [PatientController::class, 'destroy']);
        
        // HT Examinations
        Route::get('/ht-examinations', [HtExaminationController::class, 'index']);
        Route::post('/ht-examinations', [HtExaminationController::class, 'store']);
        Route::get('/ht-examinations/{htExamination}', [HtExaminationController::class, 'show']);
        Route::put('/ht-examinations/{htExamination}', [HtExaminationController::class, 'update']);
        Route::delete('/ht-examinations/{htExamination}', [HtExaminationController::class, 'destroy']);
        
        // DM Examinations
        Route::get('/dm-examinations', [DmExaminationController::class, 'index']);
        Route::post('/dm-examinations', [DmExaminationController::class, 'store']);
        Route::get('/dm-examinations/{dmExamination}', [DmExaminationController::class, 'show']);
        Route::put('/dm-examinations/{dmExamination}', [DmExaminationController::class, 'update']);
        Route::delete('/dm-examinations/{dmExamination}', [DmExaminationController::class, 'destroy']);
    });
});