<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller {
    // Hiển thị danh sách tin tức
    public function index() {
        $news = News::latest()->paginate(6); // Lấy tin tức mới nhất, phân trang 6 bài
        return view('news.index', compact('news'));
    }

    // Hiển thị chi tiết tin tức
    public function show($slug) {
        $newsItem = News::where('slug', $slug)->firstOrFail();
        return view('news.show', compact('newsItem'));
    }
}
