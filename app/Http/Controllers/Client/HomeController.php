<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $bestSellingProducts = Product::select('products.*')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_items', 'product_variants.id', '=', 'order_items.variant_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed') // Chỉ tính đơn đã hoàn thành
            ->groupBy('products.id')
            ->orderByRaw('SUM(order_items.quantity) DESC')
            ->limit(8)
            ->get();

        $categories = Category::whereNull('parent_id')->get();
        $trendingProducts = Product::orderBy('view_count', 'DESC')
            ->limit(8)
            ->get();
        $posts = Post::with(['user', 'tags', 'categories'])->inRandomOrder()
            ->limit(8)
            ->get(); // Lấy 8 bài post ngẫu nhiên

            $settings = Setting::pluck('value', 'key')->toArray();


        return view('client.home', compact('bestSellingProducts', 'trendingProducts', 'posts','categories'));
    }

    public function notFound()
    {
        return view('client.404');
    }
}
