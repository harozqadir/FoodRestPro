<?php

namespace App\Providers;

use App\Models\SubCategory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        view()->composer('includes.header', function ($view) {
            $view->with('sub_categories',SubCategory::select('id','name_en')->get());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
