<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price_default' => 'required|numeric|min:0',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'avatar' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required|in:active,inactive'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'short_description.required' => 'Mô tả ngắn không được để trống.',
            'short_description.string' => 'Mô tả ngắn phải là chuỗi ký tự.',
            'short_description.max' => 'Mô tả ngắn không được vượt quá 500 ký tự.',
            'full_description.required' => 'Mô tả chi tiết không được để trống.',
            'avatar.image' => 'Ảnh đại diện phải là một hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png hoặc jpg.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'category_id.required' => 'Vui lòng chọn danh mục cho sản phẩm.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',
            'brand_id.required' => 'Vui lòng chọn thương hiệu cho sản phẩm.',
            'brand_id.exists' => 'Thương hiệu đã chọn không hợp lệ.',
            'status.required' => 'Vui lòng chọn trạng thái cho sản phẩm.',
            'status.in' => 'Trạng thái sản phẩm không hợp lệ.'
        ];
    }
}
