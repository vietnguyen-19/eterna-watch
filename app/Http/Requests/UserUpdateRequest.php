<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép request được thực thi
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'note' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'specific_address' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'name.string' => 'Họ và tên phải là chuỗi ký tự.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',

            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',

            'gender.in' => 'Giới tính không hợp lệ.',

            'note.string' => 'Ghi chú phải là chuỗi ký tự.',
            'note.max' => 'Ghi chú không được vượt quá 1000 ký tự.',

            'avatar.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg hoặc gif.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',

            'country.required' => 'Vui lòng nhập quốc gia.',
            'city.required' => 'Vui lòng nhập thành phố.',
            'district.required' => 'Vui lòng nhập quận/huyện.',
            'ward.required' => 'Vui lòng nhập phường/xã.',
            'specific_address.required' => 'Vui lòng nhập địa chỉ chi tiết.',
        ];
    }
}
