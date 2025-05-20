<?php

namespace App\Providers;

use App\Models\Category;
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
            // $sub_categories = SubCategory::select('id','name_en')->get()->each(function ($q){
            //     $q->setAppends([]);
            // });
             $categories = Category::select(['id','name_ckb','name_ar','name_en'])
             ->with('sub_categories:id,name_ckb,name_en,name_ar,category_id')->get()->each(function ($q){
                $q->setAppends([]);
            });
            $view->with('categories',$categories);
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
