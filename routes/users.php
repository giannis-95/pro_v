<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/users/export-excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
Route::get('/users/export-pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');


Route::resource('users' , UserController::class);

Route::get('/user/{id}/restore',              [UserController::class,'restore_user'])->name('user.restore');
Route::get('/user/{id}/final_deleted',        [UserController::class,'final_deleted'])->name('user.final_deleted');

