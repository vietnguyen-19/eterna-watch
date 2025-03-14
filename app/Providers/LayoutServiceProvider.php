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

            // Lấy thương hiệu cha + con và đếm số sản phẩm
            $brands = Brand::whereNull('parent_id')
                ->with('children')
                ->get()
                ->map(function ($brand) {
                    $brand->products_count = $brand->allProducts()->count();
                    return $brand;
                });
            $settings = Setting::pluck('value', 'key_name');


            $view->with(compact('categories', 'brands', 'settings'));
        });
    }
}
