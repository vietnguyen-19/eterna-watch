<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'image_link' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'redirect_link' => 'nullable|string|url|max:250',
        ];
    }

    public function messages()
    {
        return [
            'image_link.required' => 'Vui lòng chọn một ảnh.',
            'image_link.image' => 'File tải lên phải là ảnh.',
            'image_link.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image_link.max' => 'Ảnh không được vượt quá 2MB.',

            'redirect_link.url' => 'Đường dẫn chuyển hướng phải là một URL hợp lệ.',
            'redirect_link.max' => 'Đường dẫn chuyển hướng không được dài quá 250 ký tự.',
        ];
    }
}
