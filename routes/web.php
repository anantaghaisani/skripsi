<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tryout Routes
    Route::prefix('tryout')->name('tryout.')->group(function () {
        Route::get('/', [TryoutController::class, 'index'])->name('index');
        Route::get('/{id}', [TryoutController::class, 'show'])->name('show');
        Route::post('/{id}/start', [TryoutController::class, 'start'])->name('start');
        Route::get('/{id}/work', [TryoutController::class, 'work'])->name('work');
        Route::post('/{id}/submit', [TryoutController::class, 'submit'])->name('submit');
    });

    // Module Routes
    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('index');
        Route::get('/{id}', [ModuleController::class, 'show'])->name('show');
        Route::get('/{id}/view-pdf', [ModuleController::class, 'viewPdf'])->name('view-pdf');
        Route::get('/{id}/download-pdf', [ModuleController::class, 'downloadPdf'])->name('download-pdf');
    });
});