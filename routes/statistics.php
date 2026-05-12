<?php

use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('statistics',                    [StatisticsController::class,'index'])->name('statistics.index');
Route::get('statistics/courses',            [StatisticsController::class,'courses'])->name('statistics.courses');
Route::get('statistics/my-courses',         [StatisticsController::class,'my_courses'])->name('statistics.my-courses');
Route::get('statistics/announcements',      [StatisticsController::class,'announcements'])->name('statistics.announcements');
