<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SubCategory;
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
    view()->composer('includes.header', function ($view) {
        $categories = Category::with('sub_categories')->get();
        $view->with('categories', $categories);
    
    });
        
}
}
