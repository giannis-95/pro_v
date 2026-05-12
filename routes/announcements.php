<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;

Route::get('/announcements/export-excel',                   [AnnouncementController::class,'export_excel'])->name('announcements.export-excel');
Route::get('/announcements/export-pdf',                     [AnnouncementController::class,'export_pdf'])->name('announcements.export-pdf');
Route::get('announcements/{announcement}/download-file',    [AnnouncementController::class,'download_file'])->name('announcements.download-file');
Route::resource('announcements' , AnnouncementController::class);
