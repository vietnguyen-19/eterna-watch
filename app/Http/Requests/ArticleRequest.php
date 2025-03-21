<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Xác định quyền gửi Request (true: cho phép, false: từ chối).
     */
    public function authorize(): bool
    {
        return true; // Cho phép gửi request
    }

    /**
     * Quy tắc kiểm tra dữ liệu đầu vào (Validation rules).
     */
    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'author'  => 'required|string|max:100',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'title.required'   => 'Tiêu đề không được để trống.',
            'title.max'        => 'Tiêu đề tối đa 255 ký tự.',
            'content.required' => 'Nội dung không được để trống.',
            'content.min'      => 'Nội dung phải có ít nhất 10 ký tự.',
            'image.image'      => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes'      => 'Ảnh phải có định dạng jpg, jpeg, png.',
            'image.max'        => 'Dung lượng ảnh không vượt quá 2MB.',
            'author.required'  => 'Tác giả không được để trống.',
            'author.max'       => 'Tên tác giả tối đa 100 ký tự.',
        ];
    }
}
