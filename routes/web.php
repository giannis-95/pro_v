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

    Route::get('/course/${id}/registration',                   [CourseController::class,'course_registration'])->name('course.registration');
    Route::get('/course/${id}/unregistration_course_email',    [CourseController::class,'unregistration_course_email'])->name('course.unregistration_course_email');
    Route::get('/course/${id}/unregistration_course',          [CourseController::class,'unregistration_course'])->name('course.unregistration_course');
});

require __DIR__.'/auth.php';
