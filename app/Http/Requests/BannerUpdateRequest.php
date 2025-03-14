<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Cho phép cập nhật mà không bắt buộc ảnh
            'redirect_link' => 'nullable|string|url|max:250',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image_link.image' => 'File tải lên phải là ảnh.',
            'image_link.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image_link.max' => 'Ảnh không được vượt quá 2MB.',

            'redirect_link.url' => 'Đường dẫn chuyển hướng phải là một URL hợp lệ.',
            'redirect_link.max' => 'Đường dẫn chuyển hướng không được dài quá 250 ký tự.',
        ];
    }
}
