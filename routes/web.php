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

// Temporary logout route
Route::get('/logout-now', function() {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('status', 'Berhasil logout!');
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

// Student Routes (role: student) - WITH 'active' MIDDLEWARE
Route::middleware(['auth', 'role:student', 'active'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tryout Routes
    Route::prefix('tryout')->name('tryout.')->group(function () {
        Route::get('/', [TryoutController::class, 'index'])->name('index');
        Route::get('/{id}', [TryoutController::class, 'show'])->name('show');
        Route::post('/{id}/start', [TryoutController::class, 'start'])->name('start');
        Route::get('/{id}/work', [TryoutController::class, 'work'])->name('work');
        Route::post('/{id}/save-answer', [TryoutController::class, 'saveAnswer'])->name('save-answer');
        Route::post('/{id}/submit', [TryoutController::class, 'submit'])->name('submit');
        Route::get('/{id}/result', [TryoutController::class, 'result'])->name('result');
        Route::get('/{id}/review', [TryoutController::class, 'review'])->name('review');
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

// Tentor Routes (role: tentor) - WITH 'active' MIDDLEWARE
Route::middleware(['auth', 'role:tentor', 'active'])->prefix('tentor')->name('tentor.')->group(function () {
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

    // Module Management
    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/', [TentorModuleController::class, 'index'])->name('index');
        Route::get('/create', [TentorModuleController::class, 'create'])->name('create');
        Route::post('/', [TentorModuleController::class, 'store'])->name('store');
        Route::get('/{id}', [TentorModuleController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [TentorModuleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TentorModuleController::class, 'update'])->name('update');
        Route::delete('/{id}', [TentorModuleController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [TentorModuleController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/bulk-delete', [TentorModuleController::class, 'bulkDelete'])->name('bulk-delete');
    });

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [TentorProfileController::class, 'index'])->name('index');
        Route::put('/update-password', [TentorProfileController::class, 'updatePassword'])->name('update-password');
        Route::put('/update-photo', [TentorProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [TentorProfileController::class, 'deletePhoto'])->name('delete-photo');
    });
});

// Admin Routes (role: admin) - NO 'active' MIDDLEWARE (admin always active)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Admin Question Management Routes
    Route::prefix('question')->name('question.')->group(function () {
        Route::get('/{tryout}', [App\Http\Controllers\Admin\QuestionController::class, 'index'])->name('index');
        Route::get('/{tryout}/create', [App\Http\Controllers\Admin\QuestionController::class, 'create'])->name('create');
        Route::post('/{tryout}', [App\Http\Controllers\Admin\QuestionController::class, 'store'])->name('store');
        Route::get('/{tryout}/bulk-create', [App\Http\Controllers\Admin\QuestionController::class, 'bulkCreate'])->name('bulk-create');
        Route::post('/{tryout}/bulk-store', [App\Http\Controllers\Admin\QuestionController::class, 'bulkStore'])->name('bulk-store');
        Route::get('/{tryout}/{question}/edit', [App\Http\Controllers\Admin\QuestionController::class, 'edit'])->name('edit');
        Route::put('/{tryout}/{question}', [App\Http\Controllers\Admin\QuestionController::class, 'update'])->name('update');
        Route::delete('/{tryout}/{question}', [App\Http\Controllers\Admin\QuestionController::class, 'destroy'])->name('destroy');
    });
    
    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/bulk-delete', [App\Http\Controllers\Admin\UserController::class, 'bulkDelete'])->name('bulk-delete');
    });
    
    // Class Management
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ClassController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\ClassController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\ClassController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Admin\ClassController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\ClassController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\ClassController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\ClassController::class, 'destroy'])->name('destroy');
        Route::delete('/bulk-delete', [App\Http\Controllers\Admin\ClassController::class, 'bulkDelete'])->name('bulk-delete');
        
        // Member management routes
        Route::post('/{id}/add-student', [App\Http\Controllers\Admin\ClassController::class, 'addStudent'])->name('add-student');
        Route::delete('/{id}/remove-student/{studentId}', [App\Http\Controllers\Admin\ClassController::class, 'removeStudent'])->name('remove-student');
    });
    
    // Tryout Management (admin can see all)
    Route::prefix('tryout')->name('tryout.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TryoutController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\TryoutController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\TryoutController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Admin\TryoutController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\TryoutController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\TryoutController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\TryoutController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [App\Http\Controllers\Admin\TryoutController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/{id}/monitor', [App\Http\Controllers\Admin\TryoutController::class, 'monitor'])->name('monitor');
        Route::get('/{tryoutId}/result/{userId}', [App\Http\Controllers\Admin\TryoutController::class, 'showResult'])->name('result');
    });
    
    // Module Management (admin can see all)
    Route::prefix('module')->name('module.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ModuleController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\ModuleController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\ModuleController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Admin\ModuleController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\ModuleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\ModuleController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\ModuleController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [App\Http\Controllers\Admin\ModuleController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/bulk-delete', [App\Http\Controllers\Admin\ModuleController::class, 'bulkDelete'])->name('bulk-delete');
    });
    
    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('index');
        Route::put('/update-password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('update-password');
        Route::put('/update-photo', [App\Http\Controllers\Admin\ProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [App\Http\Controllers\Admin\ProfileController::class, 'deletePhoto'])->name('delete-photo');
    });
});