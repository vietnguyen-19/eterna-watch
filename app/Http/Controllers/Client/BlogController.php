<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {    // Lấy danh mục cha với children và đếm số bài viết
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->withCount('posts')
            ->get();

        $brands = Brand::whereNull('parent_id')
            ->with('children')
            ->get();

        // Lấy danh sách tag và đếm số bài viết
        $tags = Tag::withCount('posts')->get();

        // Khởi tạo truy vấn bài viết với các quan hệ liên quan
        $postsQuery = Post::with(['user', 'tags', 'categories']);

        // Lọc theo danh mục nếu có
        if ($request->has('category')) {
            $categoryName = $request->input('category');
            $postsQuery->whereHas('categories', function ($query) use ($categoryName) {
                $query->where('name', $categoryName);
            });
        }

        // Lọc theo tag nếu có
        if ($request->has('tag')) {
            $tagName = $request->input('tag');
            $postsQuery->whereHas('tags', function ($query) use ($tagName) {
                $query->where('name', $tagName);
            });
        }

        // Phân trang kết quả
        $posts = $postsQuery->paginate(12);

        return view('client.blog', compact('categories', 'brands', 'posts', 'tags'));
    }
    public function show($id)
    {
        $post = Post::with(['tags', 'categories'])->findOrFail($id);
        // Lấy danh mục cha với children và đếm số bài viết
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->withCount('posts')
            ->get();

        $brands = Brand::whereNull('parent_id')
            ->with('children')
            ->get();

        // Lấy danh sách tag và đếm số bài viết
        $tags = Tag::withCount('posts')->get();
        return view('client.post', compact('post', 'tags', 'categories','brands'));
    }
}
