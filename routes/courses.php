<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::resource('courses', CourseController::class);

Route::get('/course/{id}/registration',                   [CourseController::class,'course_registration'])->name('course.registration');
Route::get('/course/{id}/unregistration_course_email',    [CourseController::class,'unregistration_course_email'])->name('course.unregistration_course_email');
Route::get('/course/{id}/unregistration_course',          [CourseController::class,'unregistration_course'])->name('course.unregistration_course');
Route::get('/course/my-course',                           [CourseController::class,'my_course'])->name('courses.my-course');
Route::get('/course/{id}/restore',                        [CourseController::class,'restore'])->name('course.restore');
Route::get('/course/{id}/final_deleted',                  [CourseController::class,'final_deleted'])->name('course.final_deleted');
