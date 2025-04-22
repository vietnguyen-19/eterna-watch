<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function indexPost(Request $request)
    {
        $status = $request->input('status', 'all');

        // Đếm số lượng theo trạng thái cho bài viết
        $postStatusCounts = [
            'all' => Comment::where('entity_type', 'post')->count(),
            'pending' => Comment::where('entity_type', 'post')->where('status', 'pending')->count(),
            'approved' => Comment::where('entity_type', 'post')->where('status', 'approved')->count(),
            'rejected' => Comment::where('entity_type', 'post')->where('status', 'rejected')->count(),
        ];

        $comments = Comment::with(['user', 'entity'])
            ->where('entity_type', 'post')
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.comments.index-post', compact('comments', 'postStatusCounts', 'status'));
    }
    public function indexProduct(Request $request)
    {
        $status = $request->input('status', 'all');

        // Đếm số lượng theo trạng thái cho sản phẩm
        $productStatusCounts = [
            'all' => Comment::where('entity_type', 'product')->count(),
            'pending' => Comment::where('entity_type', 'product')->where('status', 'pending')->count(),
            'approved' => Comment::where('entity_type', 'product')->where('status', 'approved')->count(),
            'rejected' => Comment::where('entity_type', 'product')->where('status', 'rejected')->count(),
        ];

        $comments = Comment::with(['user', 'entity'])
            ->where('entity_type', 'product')
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.comments.index-product', compact('comments', 'productStatusCounts', 'status'));
    }


    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.comments.edit', compact('comment'));
    }


    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Bình luận đã bị xóa.');
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            DB::table("comments")->whereIn('id', explode(",", $ids))->delete();
            return response()->json(['success' => "Đã xóa thành công!"]);
        } else {
            return response()->json(['error' => "Không có mục nào được chọn!"]);
        }
    }
    // app/Http/Controllers/CommentController.php
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->content = $request->input('content');
        $comment->save();

        return response()->json(['message' => 'Cập nhật bình luận thành công!']);
    }
    public function reply(Request $request)
    {
        Comment::create([
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id'),
            'user_id' => auth()->id(),
            'entity_id' => $request->input('entity_id'),
            'entity_type' => $request->input('entity_type'),
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Trả lời bình luận thành công!']);
    }
    public function approve($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->status = 'approved';
            $comment->save();
            return response()->json(['message' => 'Đã chấp nhận bình luận!']);
        }
        return response()->json(['message' => 'Không tìm thấy bình luận!'], 404);
    }

    public function reject($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->status = 'rejected';
            $comment->save();
            return response()->json(['message' => 'Bình luận đã bị từ chối!']);
        }
        return response()->json(['message' => 'Không tìm thấy bình luận!'], 404);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();
            return response()->json(['message' => 'Đã xóa bình luận!']);
        }
        return response()->json(['message' => 'Không tìm thấy bình luận!'], 404);
    }
}
