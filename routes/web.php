<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Server\TableController as ServerTableController;
use App\Http\Controllers\Server\FoodController as ServerFoodController;


Route::get('/', function () {
    Auth::logout(); // Log out the user
    return redirect()->route('login');
});

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function () {
    Route::resource('users', UserController::class)->names('admin.users')->except(['show']);
    Route::resource('categories', CategoryController::class)->names('admin.categories')->except(['show']);
    Route::resource('sub-categories', SubCategoryController::class)->names('admin.sub-categories')->except(['show']);
    Route::resource('foods', FoodController::class)->names('admin.foods')->except(['show']);
    Route::resource('tables', TableController::class)->names('admin.tables')->except(['show']);
    Route::resource('reservations', ReservationController::class)->names('admin.reservations')->except(['index']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/admin/foods', [App\Http\Controllers\Admin\FoodController::class, 'index'])->name('admin.foods.index');
}); 

Route::prefix('server')->middleware(['auth','isServer'])->group(function(){
    
    Route::get('/home',[ServerTableController::class,'index'])->name('server.home');
    Route::get('/foods/{id}',[ServerFoodController::class,'index'])->name('server.foods');
    Route::post('/foods-store',[ServerFoodController::class,'store'])->name('server.foods.store');


});


Auth::routes();


