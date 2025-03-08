<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class)->names('admin.users');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');
    
});

Auth::routes();


