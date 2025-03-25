<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Xác định người dùng có quyền gửi request này không
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Quy tắc validate dữ liệu đầu vào
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6',
            'gender' => 'required|in:male,female,other',
            'note' => 'nullable|string|max:1000',
            'role_id' => 'required|exists:roles,id',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'street_address' => 'required|string|max:255',
            'ward' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.max' => 'Số điện thoại không được quá 20 ký tự.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'role_id.required' => 'Vai trò là bắt buộc.',
            'role_id.exists' => 'Vai trò không hợp lệ.',
            'full_name.required' => 'Họ tên người nhận là bắt buộc.',
            'phone_number.required' => 'Số điện thoại người nhận là bắt buộc.',
            'street_address.required' => 'Địa chỉ chi tiết là bắt buộc.',
            'ward.required' => 'Phường/Xã là bắt buộc.',
            'district.required' => 'Quận/Huyện là bắt buộc.',
            'city.required' => 'Thành phố là bắt buộc.',
            'country.required' => 'Quốc gia là bắt buộc.',
        ];
    }
}
