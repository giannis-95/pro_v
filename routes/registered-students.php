<?php

use App\Http\Controllers\RegisteredStudentsController;
use Illuminate\Support\Facades\Route;

Route::get('/courses/{id}/registered-students',                                         [RegisteredStudentsController::class,'index'])->name('registered-students.index');
Route::post('/courses/{id}/store-students',                                             [RegisteredStudentsController::class,'store']);
Route::delete('/courses/{course_id}/unregistered-students/{unregistered_student_id}',   [RegisteredStudentsController::class,'unregistered']);
