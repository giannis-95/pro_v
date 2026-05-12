<?php

use App\Http\Controllers\History\UserHistoryController;
use Illuminate\Support\Facades\Route;

Route::get('user-histories/export-excel',   [UserHistoryController::class,'export_excel'])->name('user-histories.export-excel');
Route::get('user-histories/export-pdf',     [UserHistoryController::class,'export_pdf'])->name('user-histories.export-pdf');

Route::resource('user-histories' , UserHistoryController::class)->only(['index','show']);
