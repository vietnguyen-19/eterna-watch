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
            'phone' => 'required|regex:/^0\d{9}$/',
            'password' => 'required|min:6',
            'gender' => 'required|in:male,female,other',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive,banned,pending',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên người dùng',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (bắt đầu bằng 0 và có 10 chữ số).',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'gender.required' => 'Vui lòng chọn giới tính',
            'gender.in' => 'Giới tính không hợp lệ',
            'role_id.required' => 'Vui lòng chọn vai trò',
            'role_id.exists' => 'Vai trò không tồn tại',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ',
            'avatar.image' => 'File phải là hình ảnh',
            'avatar.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'avatar.max' => 'Kích thước hình ảnh tối đa là 2MB',

            // Địa chỉ
            // 'full_name.required' => 'Vui lòng nhập họ tên người nhận',
            // 'phone_number.required' => 'Vui lòng nhập số điện thoại người nhận',
            // 'street_address.required' => 'Vui lòng nhập địa chỉ chi tiết',
            // 'ward.required' => 'Vui lòng nhập phường/xã',
            // 'district.required' => 'Vui lòng nhập quận/huyện',
            // 'city.required' => 'Vui lòng nhập thành phố',
            // 'country.required' => 'Vui lòng nhập quốc gia',
        ];
    }
}
