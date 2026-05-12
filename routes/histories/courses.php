<?php

use App\Http\Controllers\History\CourseHistoryController;
use Illuminate\Support\Facades\Route;

// Exports
Route::get('course-histories/export-excel',     [CourseHistoryController::class,'export_excel'])->name('course-histories.export-excel');
Route::get('course-histories/export-pdf',       [CourseHistoryController::class,'export_pdf'])->name('course-histories.export-pdf');

Route::resource('course-histories' , CourseHistoryController::class)->only(['index','show']);
