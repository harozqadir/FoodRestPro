<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Casher\CasherController;
use App\Http\Controllers\Casher\CasherInvoiceController;
use App\Http\Controllers\Casher\CasherTableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Server\TableController as ServerTableController;
use App\Http\Controllers\Server\FoodController as ServerFoodController;
use App\Http\Controllers\Chief\FoodController as ChiefFoodController;
use App\Http\Controllers\Chief\OrderController;





// Login route (must be before Auth::routes and NOT in any middleware group)
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect('/admin/home');
        } elseif ($user->isServer()) {
            return redirect('/server/home');
        } elseif ($user->isChief()) {
            return redirect('/chief/home');
        } elseif ($user->isCasher()) {
            return redirect('/casher/home');
        }
        return redirect('/home');
    }
    // If not authenticated, go to login
    return redirect()->route('login');

});
// Admin routes
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('users', UserController::class)->names('admin.users')->except(['show']);
    Route::resource('categories', CategoryController::class)->names('admin.categories')->except(['show']);
    Route::resource('sub-categories', SubCategoryController::class)->names('admin.sub-categories')->except(['show']);
    Route::resource('foods', FoodController::class)->names('admin.foods')->except(['show']);
    Route::resource('tables', TableController::class)->names('admin.tables')->except(['show']);
    Route::resource('reservations', ReservationController::class)->names('admin.reservations')->except(['index']);
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/admin/foods', [FoodController::class, 'index'])->name('admin.foods.index');
});

// Server routes
Route::prefix('server')->middleware(['auth', 'isServer'])->group(function () {
    Route::get('/home', [ServerTableController::class, 'index'])->name('server.home');
    Route::get('/foods/{id}', [ServerFoodController::class, 'index'])->name('server.foods');
    Route::post('/foods-store', [ServerFoodController::class, 'store'])->name('server.foods.store');
    Route::post('/foods-plus-or-minus/{id}/{value}', [ServerFoodController::class, 'plus_or_minus'])->name('server.foods.plus_or_minus');
    Route::post('/invoice-delete/{id}', [ServerTableController::class, 'deleteInvoice'])->name('server.invoice.delete');
});

// Chief routes
Route::prefix('chief')->middleware(['auth', 'isChief'])->group(function () {
    Route::get('/foods', [ChiefFoodController::class, 'index'])->name('chief.foods.index');
    Route::post('/foods-update-available/{id}', [ChiefFoodController::class, 'update_available'])->name('chief.foods.update');
    Route::get('/home', [OrderController::class, 'index'])->name('chief.home');
    Route::post('/server/food-invoice/{id}/update-quantity', [FoodController::class, 'updateQuantity'])->name('server.food-invoice.updateQuantity');
    Route::post('/foods-update-state/{id}/{state}', [OrderController::class, 'update_state'])->name('chief.update-state');
});

// Casher routes
Route::prefix('casher')->middleware(['auth', 'isCasher'])->group(function () {
    Route::get('/home', [CasherTableController::class, 'index'])->name('casher.home');
    Route::get('/tables/{id}', [CasherInvoiceController::class, 'show'])->name('casher.tables.invoice');
    Route::post('/process-payment/{id}', [CasherInvoiceController::class, 'processPayment'])->name('casher.process.payment');  
    Route::get('/invoices', [CasherInvoiceController::class, 'report'])->name('casher.invoices.report');
});

Auth::routes();
// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/', function () {
//     return view('welcome');
// });