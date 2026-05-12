<?php

use App\Http\Controllers\History\AnnouncementHistoryController;
use Illuminate\Support\Facades\Route;

Route::get('announcement-histories/export-excel',   [AnnouncementHistoryController::class,'export_excel'])->name('announcement-histories.export-excel');
Route::get('announcement-histories/export-pdf',     [AnnouncementHistoryController::class,'export_pdf'])->name('announcement-histories.export-pdf');

Route::resource('announcement-histories' , AnnouncementHistoryController::class)->only(['index','show']);
