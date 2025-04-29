<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHandler;
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
    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('defaultAddress')
            ->where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->limit(10)
            ->get();
        $filteredUsers = $users->map(function ($user) {
            return [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'phone'  => $user->phone,
                'address' => $user->defaultAddress ? [
                    'city'              => $user->defaultAddress->city ?? '',
                    'district'          => $user->defaultAddress->district ?? '',
                    'ward'              => $user->defaultAddress->ward ?? '',
                    'street_address'  => $user->defaultAddress->street_address ?? '',
                ] : null, // Nếu không có address thì trả về null
            ];
        });

        return response()->json($filteredUsers);
    }

    public function index()
    {
        $posts = Post::with(['user', 'tags', 'categories'])->latest()->get();
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
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,published',
            'image'         => 'required|image|max:2048',
            'published_at' => 'required|date|after_or_equal:today',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);


        // Lấy dữ liệu từ request
        $data = $request->only(['title','user_id', 'content', 'excerpt', 'status', 'published_at']);
        $user = User::where('id', $request->usser_id)->first();
        // Xử lý file upload ảnh (nếu có)
        if ($request->hasFile('image')) {
            $data['image'] = ImageHandler::saveImage($request->file('image'), 'blogs');
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

        return redirect()->route('admin.posts.index')->with('success', 'Tạo mới bài viết thành công');
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
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,published',
            'image'         => 'nullable|image|max:2048',
            'published_at' => 'required|date|after_or_equal:today',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $data = $request->only(['title', 'content', 'excerpt', 'status', 'published_at']);
        $user = User::where('id', $request->user_id)->first();

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            $data['image'] = ImageHandler::updateImage($request->file('image'), $post->image, 'blogs');
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

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Xoá ảnh nếu có
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            ImageHandler::deleteImage($post->image);
        }

        // Hủy liên kết với tags và categories
        $post->tags()->detach();
        $post->categories()->detach();

        // Xoá mềm
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được xóa tạm thời.');
    }
    public function trash()
    {
        $posts = Post::onlyTrashed()->latest()->paginate(10);
        return view('admin.posts.trash', compact('posts'));
    }
    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('admin.posts.trash')
            ->with('success', 'Bài viết đã được khôi phục thành công.');
    }
    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        // Xoá ảnh nếu có
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            ImageHandler::deleteImage($post->image);
        }

        // Hủy liên kết với tags và categories
        $post->tags()->detach();
        $post->categories()->detach();

        // Xoá vĩnh viễn
        $post->forceDelete();

        return redirect()->route('admin.posts.trash')
            ->with('success', 'Bài viết đã bị xoá vĩnh viễn.');
    }
}
