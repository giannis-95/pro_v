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

    //users
    Route::get('/user/{id}/restore',              [UserController::class,'restore_user'])->name('user.restore');
    Route::get('/user/{id}/final_deleted',        [UserController::class,'final_deleted'])->name('user.final_deleted');

    // courses
    Route::get('/course/{id}/registration',                   [CourseController::class,'course_registration'])->name('course.registration');
    Route::get('/course/{id}/unregistration_course_email',    [CourseController::class,'unregistration_course_email'])->name('course.unregistration_course_email');
    Route::get('/course/{id}/unregistration_course',          [CourseController::class,'unregistration_course'])->name('course.unregistration_course');
    Route::get('/course/my-course',                           [CourseController::class,'my_course'])->name('courses.my-course');
    Route::get('/course/{id}/restore',                        [CourseController::class,'restore'])->name('course.restore');
    Route::get('/course/{id}/final_deleted',                  [CourseController::class,'final_deleted'])->name('course.final_deleted');
});

require __DIR__.'/auth.php';
