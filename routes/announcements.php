<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;

Route::resources(['announcements' => AnnouncementController::class]);
Route::get('announcements/{announcement}/download-file',    [AnnouncementController::class,'download_file'])->name('announcements.download-file');
