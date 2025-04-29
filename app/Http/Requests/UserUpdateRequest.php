<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép request được thực thi
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email,' . $userId,
            'phone' => 'required|regex:/^0\d{9}$/',
            'password' => 'nullable|min:6',
            'gender' => 'required|in:male,female,other',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive,banned,pending',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',

            // Địa chỉ
            'street_address' => 'nullable|string|max:255',
            'ward' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên người dùng.',
            'name.string' => 'Tên người dùng phải là chuỗi ký tự.',
            'name.max' => 'Tên người dùng không được vượt quá 255 ký tự.',

            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email này đã được sử dụng.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (bắt đầu bằng 0 và có 10 chữ số).',

            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính không hợp lệ. Vui lòng chọn một trong các giá trị: nam, nữ, khác.',

            'role_id.required' => 'Vui lòng chọn vai trò.',
            'role_id.exists' => 'Vai trò được chọn không tồn tại.',

            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ. Vui lòng chọn một trong các giá trị: kích hoạt, không kích hoạt, bị cấm, đang chờ.',

            'avatar.image' => 'Tệp tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg hoặc gif.',
            'avatar.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',

            'note.string' => 'Ghi chú phải là chuỗi ký tự.',

            // Địa chỉ
            'street_address.string' => 'Địa chỉ chi tiết phải là chuỗi ký tự.',
            'street_address.max' => 'Địa chỉ chi tiết không được vượt quá 255 ký tự.',

            'ward.string' => 'Phường/Xã phải là chuỗi ký tự.',
            'ward.max' => 'Phường/Xã không được vượt quá 255 ký tự.',

            'district.string' => 'Quận/Huyện phải là chuỗi ký tự.',
            'district.max' => 'Quận/Huyện không được vượt quá 255 ký tự.',

            'city.string' => 'Tỉnh/Thành phố phải là chuỗi ký tự.',
            'city.max' => 'Tỉnh/Thành phố không được vượt quá 255 ký tự.',
        ];
    }
}
