<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class)->names('admin.users')->except(['show']);
    Route::resource('categories', CategoryController::class)->names('admin.categories')->except(['show']);
    Route::resource('sub-categories', SubCategoryController::class)->names('admin.sub-categories')->except(['show']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
});

Auth::routes();


