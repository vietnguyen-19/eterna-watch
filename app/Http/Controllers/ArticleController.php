<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // 1. Hiển thị danh sách bài viết
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    // 2. Hiển thị form thêm bài viết
    public function create()
    {
        return view('admin.articles.create');
    }

    // 3. Xử lý lưu bài viết
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'author' => 'required|max:100',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('articles', 'public') : null;

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'author' => $request->author,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Bài viết đã được thêm.');
    }

    // 4. Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    // 5. Xử lý cập nhật bài viết
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'author' => 'required|max:100',
        ]);

        $article = Article::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
            $article->image = $imagePath;
        }

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Cập nhật bài viết thành công.');
    }

    // 6. Xóa bài viết
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Bài viết đã bị xóa.');
    }
}
