<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
     

        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    view()->composer('*', function ($view) {
        $categories = Category::all();
        $view->with('categories', $categories);
    
    });
   
        
}
}
