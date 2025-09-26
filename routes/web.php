<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',     [AuthenticatedSessionController::class ,'create'])->name('login');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function(){
    Route::resources([
        'users' => UserController::class,
        'courses' => CourseController::class
    ]);
});

require __DIR__.'/auth.php';
