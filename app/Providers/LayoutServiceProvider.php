<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $categories = Category::whereNull('parent_id')
                ->with('children')
                ->get()
                ->map(function ($category) {
                    $category->products_count = $category->allProducts()->count();
                    return $category;
                });

            // Lấy tất cả thương hiệu
            $brands = Brand::with('children')->get();
            // $settings = Setting::get();
           $settings = Setting::pluck('value', 'key')->toArray();

            $view->with(compact('categories', 'brands', 'settings'));
        });
    }
}
