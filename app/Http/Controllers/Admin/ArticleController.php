<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Hiển thị danh sách bài viết
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    // Hiển thị form thêm bài viết
    public function create()
    {
        return view('admin.articles.create');
    }

    // Xử lý lưu bài viết
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'author' => 'nullable|max:255',
        ]);

        $imagePath = $request->file('image') 
            ? $request->file('image')->store('articles', 'public') 
            : null;

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'author' => $request->author,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Thêm bài viết thành công!');
    }

    // Hiển thị form sửa bài viết
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    // Xử lý cập nhật bài viết
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'author' => 'nullable|max:255',
        ]);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
        } else {
            $imagePath = $article->image;
        }

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'author' => $request->author,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    // Xóa bài viết
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Xóa bài viết thành công!');
    }

    // Hiển thị chi tiết bài viết
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.show', compact('article'));
    }
}
