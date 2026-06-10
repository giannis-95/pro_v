<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
    require __DIR__ . '/notification.php';
    require __DIR__ . '/statistics.php';
    require __DIR__ . '/histories/users.php';
    require __DIR__ . '/histories/courses.php';
    require __DIR__ . '/histories/announcements.php';
    require __DIR__ . '/message.php';
    require __DIR__ . '/registered-students.php';
    require __DIR__ . '/payments.php';
});

require __DIR__.'/auth.php';
