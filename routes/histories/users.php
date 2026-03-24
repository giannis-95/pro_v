<?php

use App\Http\Controllers\History\UserHistoryController;
use Illuminate\Support\Facades\Route;

Route::resource('user-histories' , UserHistoryController::class)->only(['index','show']);
