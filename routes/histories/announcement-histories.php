<?php

use App\Http\Controllers\History\AnnouncementHistoryController;
use Illuminate\Support\Facades\Route;

Route::resource('announcement-histories' , AnnouncementHistoryController::class)->only(['index','show']);
