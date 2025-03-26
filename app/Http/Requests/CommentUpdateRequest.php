<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
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
            'content' => 'required|string|min:3|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
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
            'content.required' => 'Nội dung bình luận là bắt buộc.',
            'content.min' => 'Nội dung bình luận phải có ít nhất 3 ký tự.',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
            'rating.integer' => 'Số sao phải là số nguyên.',
            'rating.min' => 'Số sao không được nhỏ hơn 1.',
            'rating.max' => 'Số sao không được lớn hơn 5.',
        ];
    }
}
