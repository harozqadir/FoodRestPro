<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TableController as AdminTableController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Casher\CasherController;
use App\Http\Controllers\Casher\CasherInvoiceController;
use App\Http\Controllers\Casher\CasherReportController;
use App\Http\Controllers\Casher\CasherTableController;
use App\Http\Controllers\Chef\OrderController as ChefOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Server\TableController as ServerTableController;
use App\Http\Controllers\Server\FoodController as ServerFoodController;
use App\Http\Controllers\Chef\FoodController as ChefFoodController;
use App\Http\Controllers\Chef\OrderController;
use App\Http\Controllers\Server\ServerTableController as ServerServerTableController;
use App\Http\Controllers\LangController;

// Login route (must be before Auth::routes and NOT in any middleware group)
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect('/admin/home');
        } elseif ($user->isServer()) {
            return redirect('/server/home');
        } elseif ($user->isChef()) {
            return redirect('/chef/home');
        } elseif ($user->isCasher()) {
            return redirect('/casher/home');
        }
        return redirect('/home');
    }
    // If not authenticated, go to login
    return redirect()->route('login');
});

Route::get('/lang/{locale}', function ($locale) {
    session()->put('locale', $locale);
    app()->setLocale($locale);
    return redirect()->back();
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('users', UserController::class)->names('admin.users');
    Route::resource('categories', CategoryController::class)->names('admin.categories')->except(['show']);
    Route::resource('sub-categories', SubCategoryController::class)->names('admin.sub-categories')->except(['show']);
    Route::resource('foods', FoodController::class)->names('admin.foods')->except(['show']);
    Route::resource('tables', AdminTableController::class)->names('admin.tables')->except(['show']);
    Route::resource('reservations', ReservationController::class)->names('admin.reservations')->except(['show']);
    Route::get('/admin/dashboard', [HomeController::class, 'showDashboard']);
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
});

// Server routes
Route::prefix('server')->middleware(['auth', 'isServer'])->group(function () {
    Route::get('/home', [ServerServerTableController::class, 'index'])->name('server.home');
    Route::get('/delete-invoice/{id}', [ServerServerTableController::class, 'deleteInvoice'])->name('server.deleteInvoice');
    // Food routes
    Route::get('/foods/{id}', [ServerFoodController::class, 'index'])->name('server.foods');
    Route::post('/foods-store', [ServerFoodController::class, 'store'])->name('server.foods.store');
    Route::post('/foods-plus-or-minus/{id}/{value}', [ServerFoodController::class, 'plus_or_minus'])->name('server.foods.plus_or_minus');
    Route::post('/invoice-delete/{id}', [ServerServerTableController::class, 'deleteInvoice'])->name('server.invoice.delete');
});

// Chef routes
Route::prefix('chef')->middleware(['auth', 'isChef'])->group(function () {
    Route::get('/home', [OrderController::class, 'index'])->name('chef.home');
    Route::get('/foods', [ChefFoodController::class, 'index'])->name('chef.foods.index');
    Route::post('/foods/update/{id}', [OrderController::class, 'updateStatus'])->name('chef.foods.update');
    Route::post('/orders/update-status/{id}/{status}', [OrderController::class, 'updateStatus'])->name('chef.orders.updateStatus');
});

// Casher routes
Route::prefix('casher')->middleware(['auth', 'isCasher'])->group(function () {
    Route::get('/home', [CasherTableController::class, 'index'])->name('casher.home');
    Route::get('/invoice/{id}', [CasherInvoiceController::class, 'index'])->name('casher.invoice.index');
    Route::get('/invoice/{id}', [CasherInvoiceController::class, 'show'])->name('casher.invoice.show');
    Route::post('/invoice/{id}/pay', [CasherInvoiceController::class, 'payInvoice'])->name('invoice.pay');
    Route::get('reports/export', [CasherReportController::class, 'exportInvoicesReport'])->name('casher.report.export');
    // Reports page (view)
    Route::get('/reports', [CasherReportController::class, 'index'])->name('casher.reports');
    // Export Invoices PDF
    Route::get('/reports/export-invoices', [CasherReportController::class, 'exportInvoicesReport'])->name('casher.reports.export.invoices');
    // Export Ordered Foods PDF
    Route::get('/reports/export-ordered-foods', [CasherReportController::class, 'exportOrderedFoodsPdf'])->name('casher.reports.export.ordered_foods');
});

// Auth routes (should be at the end)
Auth::routes();

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');





