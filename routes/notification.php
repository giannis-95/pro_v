<?php
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

//Notifications
Route::get('/notifications/send',               [NotificationController::class,'send']);
Route::post('/notifications/{id}/read',         [NotificationController::class,'mark_as_read']);

Route::resource('notifications', NotificationController::class)->only(['index','destroy']);


// Route::post('notifications/read-all',            [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
