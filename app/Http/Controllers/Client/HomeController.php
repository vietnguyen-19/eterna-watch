<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function search(Request $request)
    {
        // Lấy từ khóa và loại tìm kiếm
        $query = $request->input('query');
        $type = $request->input('type'); // type = 'product' hoặc 'post'

        // Nếu tìm kiếm sản phẩm
        if ($type === 'product') {
            $products = Product::with(['brand', 'category', 'variants'])
                ->where('name', 'LIKE', "%$query%")
                ->orWhere('name', 'LIKE', "%$query%")
                ->paginate(12);

            return view('client.shop', compact('products', 'query'));
        }

        // Nếu tìm kiếm bài viết
        if ($type === 'post') {
            $posts = Post::with(['user', 'tags', 'categories'])
                ->where('title', 'LIKE', "%$query%")
                ->orWhere('content', 'LIKE', "%$query%")
                ->paginate(12);

            $tags = Tag::withCount('posts')->get();

            return view('client.blog', compact('posts', 'tags', 'query'));
        }

        // Nếu không xác định được loại, kiểm tra cả hai (mặc định)
        $products = Product::with(['brand', 'category', 'variants'])
            ->where('name', 'LIKE', "%$query%")
            ->orWhere('name', 'LIKE', "%$query%")
            ->paginate(12);

        $posts = Post::with(['user', 'tags', 'categories'])
            ->where('title', 'LIKE', "%$query%")
            ->orWhere('content', 'LIKE', "%$query%")
            ->paginate(12);

        $tags = Tag::withCount('posts')->get();

        // Trả về view phù hợp nếu có kết quả
        if ($products->isNotEmpty()) {
            return view('client.shop', compact('products', 'query'));
        }

        if ($posts->isNotEmpty()) {
            return view('client.blog', compact('posts', 'tags', 'query'));
        }

        return view('search.no-results', compact('query'));
    }


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


        return view('client.home', compact('bestSellingProducts', 'trendingProducts', 'posts', 'categories'));
    }

    public function notFound()
    {
        return view('client.404');
    }
}
