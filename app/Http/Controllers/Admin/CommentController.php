<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentUpdateRequest;
use App\http\Requests\CommentStoreRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Comment::query()->with('user')->latest('id')->get();

        return view('admin.comments.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comments = Comment::whereNull('parent_id')->get();
        $item = Comment::findOrFail($id);  // Lấy danh mục theo ID
        return view('admin.comments.edit', compact('comments', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::findOrFail($id);


        $comment->update([
            'content' => $request->content ?? $comment->content,
        ]);

        return redirect()->route('admin.comments.index')->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Bình luận đã được cập nhật thành công.',
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);  // Tìm danh mục theo ID

        // Xóa danh mục
        $comment->delete();

        return redirect()->route('admin.comments.index')->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Bình luận đã được xóa thành công.',
            ]
        ]);
    }
}
