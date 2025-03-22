<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (Auth::check()) {
            // Xác thực dữ liệu đầu vào
            $request->validate([
                'rating' => 'required|integer|between:1,5',
                'content' => 'required|string|max:1000',
            ]);

            // Tạo bình luận mới
            $comment = new Comment();
            $comment->user_id = Auth::id();  // Lấy ID người dùng hiện tại
            $comment->entity_id = $id;  // ID sản phẩm
            $comment->entity_type = 'product';  // Loại thực thể (sản phẩm, bài viết...)
            $comment->content = $request->content;
            $comment->rating = $request->rating;
            $comment->status = 'pending';  // Trạng thái mặc định là chờ duyệt
            $comment->parent_id = $request->parent_id ?? null;  // Nếu là bình luận con, gán parent_id

            // Lưu bình luận vào cơ sở dữ liệu
            $comment->save();

            // Trả về thông báo thành công hoặc chuyển hướng về trang trước đó
            return redirect()->back()->with('success', 'Bình luận của bạn đã được gửi thành công!');
        }

        // Nếu người dùng chưa đăng nhập, yêu cầu đăng nhập
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để gửi bình luận.');
    }
    public function storePost(Request $request, $id)
    {

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (Auth::check()) {
            // Xác thực dữ liệu đầu vào
            $request->validate([
                'content' => 'required|string|max:1000',
            ]);

            // Tạo bình luận mới
            $comment = new Comment();
            $comment->user_id = Auth::id();  // Lấy ID người dùng hiện tại
            $comment->entity_id = $id;  // ID sản phẩm
            $comment->entity_type = 'post';  // Loại thực thể (sản phẩm, bài viết...)
            $comment->content = $request->content;
            $comment->rating = null;
            $comment->status = 'pending';  // Trạng thái mặc định là chờ duyệt
            $comment->parent_id = $request->parent_id ?? null;  // Nếu là bình luận con, gán parent_id
            $comment->save();
            return redirect()->back()->with('success', 'Bình luận của bạn đã được gửi thành công!');
        }

        // Nếu người dùng chưa đăng nhập, yêu cầu đăng nhập
        return redirect()->back()->with('error', 'Bạn cần đăng nhập để gửi bình luận.');
    }

    public function reply(Request $request, $commentId, $entityId)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để trả lời bình luận!');
        }

        // Validate dữ liệu đầu vào
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Tìm bình luận cha để kiểm tra tính hợp lệ
        $parentComment = Comment::where('id', $commentId)
            ->where('entity_id', $entityId)
            ->firstOrFail();

        // Tạo bình luận con
        $reply = new Comment();
        $reply->user_id = Auth::id(); // Lấy ID người dùng hiện tại
        $reply->content = $request->input('content');
        $reply->parent_id = $commentId;
        $reply->entity_id = $entityId;
        $reply->entity_type = 'product'; // Giả định entity_type là 'product'
        $reply->status = 'pending'; // Trạng thái mặc định
        $reply->save();

        return redirect()->back()->with('success', 'Đã gửi câu trả lời!');
    }
    public function delete($commentId, $entityId)
    {
        $comment = Comment::where('id', $commentId)
            ->where('entity_id', $entityId)
            ->firstOrFail();

        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Bạn không có quyền xóa bình luận này!'], 403);
        }

        $comment->delete();
        return response()->json(['success' => 'Đã xóa bình luận thành công!']);
    }
    public function update(Request $request, Comment $comment)
    {
        // Kiểm tra quyền chỉnh sửa
        if (Auth::id() !== $comment->user_id) {
            return back()->with('error', 'Bạn không có quyền chỉnh sửa bình luận này.');
        }

        // Validate dữ liệu đầu vào
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Cập nhật bình luận
        $comment->update([
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Bình luận đã được cập nhật.');
    }
}
