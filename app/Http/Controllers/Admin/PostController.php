<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'tags', 'categories'])->get();
        return view('admin.posts.index', compact('posts'));
    }
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.posts.create', compact('tags', 'categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'email_user'         => 'required|email',
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'excerpt'       => 'nullable|string',
            'status'        => 'required|in:draft,published,archived',
            'image'         => 'nullable|image|max:2048',
            'published_at'  => 'nullable|date',
            'tags'          => 'nullable|array',
            'tags.*'        => 'exists:tags,id',
            'categories'    => 'nullable|array',
            'categories.*'  => 'exists:categories,id',
        ]);

        // Lấy dữ liệu từ request
        $data = $request->only(['title', 'content', 'excerpt', 'status', 'published_at']);
        $user = User::where('email', $request->email_user)->first();
        $data['user_id'] = $user ? $user->id : null;
        // Xử lý file upload ảnh (nếu có)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        // Chuyển đổi published_at về dạng Carbon nếu có giá trị
        if (!empty($data['published_at'])) {
            $data['published_at'] = Carbon::parse($data['published_at']);
        }
        $post = Post::create($data);

        // Gán tags và categories (quan hệ nhiều-nhiều)
        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        }

        if ($request->has('categories')) {
            $post->categories()->sync($request->input('categories'));
        }

        return redirect()->route('admin.posts.index')->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Bài viết được thêm thành công.',
            ]
        ]);
    }

    public function edit($id)
    {
        $post = Post::with(['tags', 'categories'])->findOrFail($id);
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'tags', 'categories'));
    }
    public function update(Request $request, $id)
    {

        $post = Post::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'excerpt'       => 'nullable|string',
            'status'        => 'required|in:draft,published,archived',
            'image'         => 'nullable|image|max:2048',
            'published_at'  => 'nullable|date',
            'tags'          => 'nullable|array',
            'tags.*'        => 'exists:tags,id',
            'categories'    => 'nullable|array',
            'categories.*'  => 'exists:categories,id',
        ]);

        $data = $request->only(['title', 'content', 'excerpt', 'status', 'published_at']);
        $user = User::where('email', $request->email_user)->first();
        $data['user_id'] = $user ? $user->id : null;
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        if (!empty($data['published_at'])) {
            $data['published_at'] = Carbon::parse($data['published_at']);
        }

        // Cập nhật dữ liệu bài viết
        $post->update($data);

        // Cập nhật quan hệ tags và categories
        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        } else {
            $post->tags()->detach();
        }

        if ($request->has('categories')) {
            $post->categories()->sync($request->input('categories'));
        } else {
            $post->categories()->detach();
        }

        return redirect()->route('admin.posts.index')->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Bài viết được cập nhật thành công.',
            ]
        ]);
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Xóa ảnh nếu có
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Hủy kết nối với tags và categories
        $post->tags()->detach();
        $post->categories()->detach();

        $post->delete();

        return redirect()->route('admin.posts.index')->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Bài viết được đc xóa khỏi danh sách.',
            ]
        ]);
    }
}
