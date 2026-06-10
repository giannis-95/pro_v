<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::post('/buy-course',      [PaymentController::class, 'buyCourse']);
Route::post('/stripe/webhook',  [PaymentController::class, 'webhook']);
