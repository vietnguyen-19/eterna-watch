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
        $data = Comment::query()->with('user')->where('entity_type', 'post')->latest('id')->get();

        return view('admin.comments.index', compact('data'));
    }

    // show dữ liệu cho đánh giá sản phẩm
    public function productComments()
    {
        $product = Comment::query()->with('user')->where('entity_type', 'product')->latest('id')->get();

        return view('admin.comments.product', compact('product'));
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
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        // Lấy trạng thái mới từ request
        $newStatus = $request->input('status');

        // Danh sách trạng thái hợp lệ
        $validStatuses = [
            'pending' => ['approved', 'rejected'],
            'approved' => [],
            'rejected' => []
        ];
        // Kiểm tra nếu trạng thái mới hợp lệ
        $currentStatus = $comment->status;

        if (!isset($validStatuses[$currentStatus]) || !in_array($newStatus, $validStatuses[$currentStatus])) {
            return back()->with([
                'thongbao' => [
                    'type' => 'danger',
                    'message' => 'Trạng thái không hợp lệ.',
                ]
            ]);
        }

        // Kiểm tra nếu trạng thái không thay đổi
        if ($comment->status === $newStatus) {
            return back()->with([
                'thongbao' => [
                    'type' => 'info',
                    'message' => 'Trạng thái bình luận không thay đổi.',
                ]
            ]);
        }

        try {
            // Cập nhật trạng thái comment
            $comment->update([
                'status' => $newStatus,
            ]);

            if($comment->entity_type == 'product'){
                return redirect()->route('admin.comments.product')->with([
                    'thongbao' => [
                        'type' => 'success',
                        'message' => 'Trạng thái bình luận đã được cập nhật thành công.',
                    ]
                ]);
            };
            return redirect()->route('admin.comments.index')->with([
                'thongbao' => [
                    'type' => 'success',
                    'message' => 'Trạng thái bình luận đã được cập nhật thành công.',
                ]
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'thongbao' => [
                    'type' => 'danger',
                    'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                ]
            ]);
        }
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
