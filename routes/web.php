<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArrearsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\VehicleStatusController;
use App\Http\Controllers\EmployeePerformanceController;
use App\Http\Controllers\SpsopkbController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TaxpayerController;
use App\Http\Controllers\VehicleDueController;
use App\Http\Controllers\ReminderBatchController;
use App\Http\Controllers\ReminderRuleController;
use App\Http\Controllers\MessageLogController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

// --- Auth ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- Protected Routes ---
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // --- Monitoring Penagihan ---
    Route::prefix('monitoring')->name('monitoring.')->group(function () {
        // Arrears / Tunggakan
        Route::resource('arrears', ArrearsController::class)->only(['index', 'show']);

        // Tasks / Tugas
        Route::resource('tasks', TaskController::class);

        // Follow-ups
        Route::post('tasks/{task}/followups', [FollowupController::class, 'store'])->name('followups.store');
        Route::delete('followups/{followup}', [FollowupController::class, 'destroy'])->name('followups.destroy');

        // Vehicle Status
        Route::post('tasks/{task}/vehicle-status', [VehicleStatusController::class, 'store'])->name('vehicle-statuses.store');

        // Employee Performance
        Route::get('kinerja', [EmployeePerformanceController::class, 'index'])->name('kinerja.index');

        // SPSOPKB
        Route::get('spsopkb', [SpsopkbController::class, 'index'])->name('spsopkb.index');
        Route::post('spsopkb/{task}/promote', [SpsopkbController::class, 'promote'])->name('spsopkb.promote');
    });

    // --- Import ---
    Route::prefix('import')->name('import.')->middleware('role:admin,operator')->group(function () {
        Route::get('/', [ImportController::class, 'index'])->name('index');
        Route::post('/upload', [ImportController::class, 'upload'])->name('upload');
        Route::get('/template/{type}', [ImportController::class, 'downloadTemplate'])->name('template');
    });

    // --- Reminder WhatsApp ---
    Route::prefix('reminder')->name('reminder.')->group(function () {
        // Taxpayers
        Route::resource('taxpayers', TaxpayerController::class)->only(['index', 'show', 'edit', 'update']);
        Route::post('taxpayers/{taxpayer}/toggle-optout', [TaxpayerController::class, 'toggleOptOut'])->name('taxpayers.toggle-optout');

        // Vehicles (due date)
        Route::resource('vehicles', VehicleDueController::class)->only(['index', 'show']);

        // Reminder Rules (admin only)
        Route::resource('rules', ReminderRuleController::class)->middleware('role:admin');

        // Reminder Batches
        Route::resource('batches', ReminderBatchController::class)->only(['index', 'show', 'create', 'store']);
        Route::post('batches/{batch}/approve', [ReminderBatchController::class, 'approve'])->name('batches.approve')->middleware('role:admin,supervisor');
        Route::post('batches/{batch}/reject', [ReminderBatchController::class, 'reject'])->name('batches.reject')->middleware('role:admin,supervisor');
        Route::post('batches/{batch}/schedule', [ReminderBatchController::class, 'schedule'])->name('batches.schedule');

        // Message Logs
        Route::get('logs', [MessageLogController::class, 'index'])->name('logs.index');
        Route::post('logs/{messageLog}/retry', [MessageLogController::class, 'retry'])->name('logs.retry');
    });

    // --- Admin: User Management ---
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('users', UserManagementController::class);
    });
});
