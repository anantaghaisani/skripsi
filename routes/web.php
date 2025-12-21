<?php


use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tentor\QuestionController as TentorQuestionController;
use App\Http\Controllers\Tentor\DashboardController as TentorDashboardController;
use App\Http\Controllers\Tentor\TryoutController as TentorTryoutController;
use App\Http\Controllers\Tentor\ModuleController as TentorModuleController;
use App\Http\Controllers\Tentor\ProfileController as TentorProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/logout-now', function() {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('status', 'Berhasil logout!');
});
Route::get('/', function () {
    return redirect()->route('login');
});

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
});

// Student Routes (role: student)
Route::middleware(['auth', 'role:student'])->group(function () {
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

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
        Route::put('/update-photo', [ProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [ProfileController::class, 'deletePhoto'])->name('delete-photo');
    });
});

// Tentor Routes (role: tentor)
Route::middleware(['auth', 'role:tentor'])->prefix('tentor')->name('tentor.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [TentorDashboardController::class, 'index'])->name('dashboard');
    
    // Tryout Management
    Route::prefix('tryout')->name('tryout.')->group(function () {
        Route::get('/', [TentorTryoutController::class, 'index'])->name('index');
        Route::get('/create', [TentorTryoutController::class, 'create'])->name('create');
        Route::post('/', [TentorTryoutController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TentorTryoutController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TentorTryoutController::class, 'update'])->name('update');
        Route::delete('/{id}', [TentorTryoutController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/monitor', [TentorTryoutController::class, 'monitor'])->name('monitor');
        Route::get('/{tryoutId}/result/{userId}', [TentorTryoutController::class, 'showResult'])->name('result');
    });

    // Module Management
    Route::prefix('module')->name('module.')->group(function () {
        Route::get('/', [TentorModuleController::class, 'index'])->name('index');
        Route::get('/create', [TentorModuleController::class, 'create'])->name('create');
        Route::post('/', [TentorModuleController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TentorModuleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TentorModuleController::class, 'update'])->name('update');
        Route::delete('/{id}', [TentorModuleController::class, 'destroy'])->name('destroy');
    });

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [TentorProfileController::class, 'index'])->name('index');
        Route::put('/update-password', [TentorProfileController::class, 'updatePassword'])->name('update-password');
        Route::put('/update-photo', [TentorProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [TentorProfileController::class, 'deletePhoto'])->name('delete-photo');
    });

    // Question Management Routes 
    Route::prefix('tryout/{tryout}/question')->name('question.')->group(function () {
        Route::get('/', [TentorQuestionController::class, 'index'])->name('index');
        Route::get('/create', [TentorQuestionController::class, 'create'])->name('create');
        Route::post('/', [TentorQuestionController::class, 'store'])->name('store');
        Route::get('/{question}/edit', [TentorQuestionController::class, 'edit'])->name('edit');
        Route::put('/{question}', [TentorQuestionController::class, 'update'])->name('update');
        Route::delete('/{question}', [TentorQuestionController::class, 'destroy'])->name('destroy');
        Route::get('/bulk-create', [TentorQuestionController::class, 'bulkCreate'])->name('bulk-create');
        Route::post('/bulk-store', [TentorQuestionController::class, 'bulkStore'])->name('bulk-store');
    });
});
