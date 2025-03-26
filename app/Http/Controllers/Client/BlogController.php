<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh mục cha với children và đếm số bài viết
        $categories = Category::whereNull('parent_id')->with('children')->withCount('posts')->get();
        $brands = Brand::whereNull('parent_id')->with('children')->get();
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

        // Áp dụng bộ lọc từ request
        if ($request->has('filter')) {
            $filter = $request->input('filter');

            switch ($filter) {
                case 'az':
                    $postsQuery->orderBy('title', 'asc'); // Sắp xếp theo tiêu đề A-Z
                    break;
                case 'za':
                    $postsQuery->orderBy('title', 'desc'); // Sắp xếp theo tiêu đề Z-A
                    break;
                case 'feature':
                    $postsQuery->orderBy('view_count', 'desc'); // Bài viết nổi bật (theo lượt xem)
                    break;
                case 'date_old':
                    $postsQuery->orderBy('created_at', 'asc'); // Ngày cũ đến mới
                    break;
                case 'date_new':
                    $postsQuery->orderBy('created_at', 'desc'); // Ngày mới đến cũ
                    break;
                default:
                    // Mặc định không sắp xếp gì cả
                    break;
            }
        }

        // Phân trang kết quả
        $posts = $postsQuery->paginate(12);

        return view('client.blog', compact('categories', 'brands', 'posts', 'tags'));
    }
    public function show($id)
    {
        $post = Post::with(['tags', 'categories'])->findOrFail($id);
        $post->increment('view_count');
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
        $comments = $this->getCommentsWithReplies($id);
        return view('client.post', compact('post', 'tags', 'categories', 'brands', 'comments'));
    }
    public function getCommentsWithReplies($postId, $parentId = null)
    {
        $comments = Comment::where('entity_id', $postId)
            ->where('entity_type', 'post')
            ->where('parent_id', $parentId)
            ->with('replies') // Để lấy các bình luận con
            ->get();

        foreach ($comments as $comment) {
            // Lấy các bình luận con của mỗi bình luận
            $comment->replies = $this->getCommentsWithReplies($postId, $comment->id);
        }

        return $comments;
    }
}
