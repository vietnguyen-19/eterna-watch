<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Request;
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
    
            $brands = Brand::with('children')->get();
            $settings = Setting::pluck('value', 'key');
    
            // Chỉ truyền banners nếu không phải trong admin
            $banners = [];
    
            if (!Request::is('admin*')) {
                $positions = [
                    'home_start',
                    'home_new_product',
                    'login',
                    'register',
                    'shop',
                    'blog',
                    'forward_password'
                ];
    
                foreach ($positions as $position) {
                    $banners[$position] = Banner::where('position', $position)
                    ->where('is_active', true) // chỉ lấy banner đang hiển thị
                    ->orderBy('id', 'desc')    // bạn có thể thay đổi theo nhu cầu
                    ->first(); 
                }
                $view->with(compact('categories', 'brands', 'settings','banners'));
            }
    
            $view->with(compact('categories', 'brands', 'settings'));
        });
    }
}
