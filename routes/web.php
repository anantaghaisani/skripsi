<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TryoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Dashboard redirect ke tryout
    Route::get('/dashboard', function () {
        return redirect()->route('tryout.index');
    })->name('dashboard');
    
    // Tryout Routes
    Route::prefix('tryout')->name('tryout.')->group(function () {
        Route::get('/', [TryoutController::class, 'index'])->name('index');
        Route::get('/{id}', [TryoutController::class, 'show'])->name('show');
        Route::post('/{id}/start', [TryoutController::class, 'start'])->name('start');
        Route::get('/{id}/work', [TryoutController::class, 'work'])->name('work');
        Route::post('/{id}/submit', [TryoutController::class, 'submit'])->name('submit');
    });
});