<?php

use App\Http\Controllers\CaledarController;
use Illuminate\Support\Facades\Route;

Route::get('caledar',    [CaledarController::class,'index'])->name('caledar.index');
