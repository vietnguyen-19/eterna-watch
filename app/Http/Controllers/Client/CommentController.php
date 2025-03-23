<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để gửi bình luận.');
        }
        $rules = [
            'content' => 'required|string|max:1000',
            'entity_type' => 'required|in:product,post',
        ];

        if ($request->entity_type === 'product') {
            $rules['rating'] = 'required|integer|between:1,5';
        }

        $messages = [
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
            'entity_type.required' => 'Loại thực thể không được để trống.',
            'entity_type.in' => 'Loại thực thể phải là product hoặc post.',
            'rating.required' => 'Bạn chưa chọn đánh giá.',
            'rating.integer' => 'Đánh giá phải là số nguyên.',
            'rating.between' => 'Đánh giá phải từ 1 đến 5 sao.',
        ];

        $request->validate($rules, $messages);

        // Tạo bình luận mới
        $comment = new Comment();
        $comment->user_id = Auth::id(); // Lấy ID người dùng hiện tại
        $comment->entity_id = $id; // ID sản phẩm hoặc bài viết
        $comment->entity_type = $request->entity_type; // Loại thực thể
        $comment->content = $request->content;
        $comment->rating = $request->entity_type === 'product' ? $request->rating : null; // Chỉ lưu rating nếu là product
        $comment->status = 'pending'; // Trạng thái mặc định là chờ duyệt
        $comment->parent_id = $request->parent_id ?? null; // Nếu là bình luận con, gán parent_id

        // Lưu bình luận vào cơ sở dữ liệu
        $comment->save();

        // Trả về thông báo thành công hoặc chuyển hướng về trang trước đó
        return redirect()->back()->with('success', 'Bình luận của bạn đã được gửi thành công!');
    }

    public function reply(Request $request, $commentId, $entityId)
    {

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để trả lời bình luận!');
        }
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:500',
        ], [
            'content.required' => 'Nội dung không được để trống.',
            'content.string'   => 'Nội dung phải là chuỗi ký tự.',
            'content.max'      => 'Nội dung không được vượt quá 500 ký tự.',
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first('content')); // Lưu lỗi vào session
            return redirect()->back()->withInput(); // Giữ lại dữ liệu nhập vào
        }
        // Tìm bình luận cha để kiểm tra tính hợp lệ
        $parentComment = Comment::where('id', $commentId)
            ->where('entity_id', $entityId)
            ->firstOrFail();
        $reply = new Comment();
        $reply->user_id = Auth::id(); // Lấy ID người dùng hiện tại
        $reply->content = $request->input('content');
        $reply->parent_id = $commentId;
        $reply->entity_id = $entityId;
        $reply->entity_type = $request->input('entity_type'); // Giả định entity_type là 'product'
        $reply->status = 'pending'; // Trạng thái mặc định
        $reply->save();

        return redirect()->back()->with('success', 'Đã gửi câu trả lời!');
    }
    public function delete($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Kiểm tra quyền xóa
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Bạn không có quyền xóa bình luận này!'], 403);
        }
        $comment->delete();
        return response()->json(['success' => true, 'message' => 'Đã xóa bình luận thành công!']);
    }

    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Bạn không có quyền chỉnh sửa bình luận này.'], 403);
        }

        $validatedData = $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        // Nếu rating là null, giữ nguyên giá trị cũ
       $validatedData['rating'] = $validatedData['rating'] ?? $comment->rating;

        $comment->update($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Bình luận đã được cập nhật.',
            'comment' => $comment
        ]);
    }
}
