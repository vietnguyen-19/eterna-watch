<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'entity_type' => 'required|string|in:products,posts',
            'content' => 'string|min:3|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
            'parent_id' => 'nullable|exists:comments,id',
        ];
    }
    /**
     * Tin nhắn lỗi để hiển thị khi xác thực thất bại.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'Bạn cần đăng nhập!',
            'entity_type.required' => 'Loại thực thể là bắt buộc.',
            'entity_type.in' => 'Loại thực thể chỉ có thể là "products" hoặc "posts".',
            'content.min' => 'Nội dung bình luận phải có ít nhất 3 ký tự.',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
            'rating.integer' => 'Số sao phải là số nguyên.',
            'rating.min' => 'Số sao không được nhỏ hơn 1.',
            'rating.max' => 'Số sao không được lớn hơn 5.',
            'parent_id.exists' => 'Bình luận cha không tồn tại.',
        ];
    }
}
