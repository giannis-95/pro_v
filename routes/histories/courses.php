<?php

use App\Http\Controllers\History\CourseHistoryController;
use Illuminate\Support\Facades\Route;

Route::resource('course-histories' , CourseHistoryController::class)->only(['index','show']);
