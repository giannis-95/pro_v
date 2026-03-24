<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',     [AuthenticatedSessionController::class ,'create'])->name('login');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function(){
    require __DIR__ . '/users.php';
    require __DIR__ . '/courses.php';
    require __DIR__ . '/announcements.php';
    require __DIR__ . '/caledar.php';
    require __DIR__ . '/histories/users.php';
    require __DIR__ . '/histories/courses.php';
    require __DIR__ . '/histories/announcements.php';

    //Notifications
    Route::get('notifications',                                 [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read',                      [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all',                       [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

require __DIR__.'/auth.php';
