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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Không bắt buộc, nhưng nếu có phải là ảnh hợp lệ
            'redirect_link' => 'nullable|url|max:250',
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
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Ảnh không được lớn hơn 2MB.',
            'redirect_link.url' => 'Đường dẫn chuyển hướng phải là một URL hợp lệ.',
            'redirect_link.max' => 'Đường dẫn chuyển hướng không được dài quá 250 ký tự.',
        ];
    }
}
