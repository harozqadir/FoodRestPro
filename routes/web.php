<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Casher\CasherController;
use App\Http\Controllers\Casher\CasherTableController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Server\TableController as ServerTableController;
use App\Http\Controllers\Server\FoodController as ServerFoodController;
use App\Http\Controllers\Chief\FoodController as ChiefFoodController;
use App\Http\Controllers\Chief\OrderController;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
   Auth::logout(); // Log out the user
   return redirect()->route('login');

// Store the data in cache for 1 minutes
//     Cache::put('users', ['haroz','server','chief'], 1); 

//     Retrieve the cached data for 'users'
//      return Cache::get('users'); 

//     Clear the cache for 'users'
//      cache::forget('users'); 
 
//     Check if the cache for 'users' exists
//    if(Cache::has('users')){
//        return 'Available';
//    }
//        else{
//          return 'Not Available';
//        }
//     Cache::flush(); // Clear all cached data

});


Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function () {
    Route::resource('users', UserController::class)->names('admin.users')->except(['show']);
    Route::resource('categories', CategoryController::class)->names('admin.categories')->except(['show']);
    Route::resource('sub-categories', SubCategoryController::class)->names('admin.sub-categories')->except(['show']);
    Route::resource('foods', FoodController::class)->names('admin.foods')->except(['show']);
    Route::resource('tables', TableController::class)->names('admin.tables')->except(['show']);
    Route::resource('reservations', ReservationController::class)->names('admin.reservations')->except(['index']);

    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/admin/foods', [FoodController::class, 'index'])->name('admin.foods.index');
});




Route::prefix('server')->middleware(['auth','isServer'])->group(function(){
    
    Route::get('/home',[ServerTableController::class,'index'])->name('server.home');
    Route::get('/foods/{id}',[ServerFoodController::class,'index'])->name('server.foods');
    Route::post('/foods/{id}/store', [ServerFoodController::class, 'store'])->name('server.foods.store');    Route::post('/foods-plus-or-minus/{id}/{value}',[ServerFoodController::class,'plus_or_minus'])->name('server.foods.plus_or_minus');
    Route::post('/invoice-delete/{id}',[ServerTableController::class,'deleteInvoice'])->name('server.invoice.delete');


});

Route::prefix('chief')->middleware(['auth','isChief'])->group(function(){
    Route::get('/foods',[ChiefFoodController::class,'index'])->name('chief.foods.index');
    Route::post('/foods-update-available/{id}',[ChiefFoodController::class,'update_available'])->name('chief.foods.update');
    Route::get('/home',[OrderController::class,'index'])->name('chief.home');
    Route::post('/foods-update-state/{id}/{state}',[OrderController::class,'update_state'])->name('chief.update-state');


});

Route::prefix('casher')->middleware(['auth','isCasher'])->group(function(){
    Route::get('/home', [CasherTableController::class, 'index'])->name('casher.home');
    Route::get('/tables/{id}/invoice', [CasherTableController::class, 'invoice'])->name('casher.tables.invoice');
    Route::delete('/tables/orders/{id}/remove', [CasherTableController::class, 'removeOrder'])->name('casher.tables.removeOrder');

});

Auth::routes();


