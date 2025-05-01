<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('client.auth.register');
    }
    public function register(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255', // Chắc chắn rằng 'name' là chuỗi và không vượt quá 255 ký tự
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits_between:9,11|unique:users,phone',
            'password' => 'required|min:6',
            're_password' => 'required|same:password',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên phải là một chuỗi.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
        
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
        
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.digits_between' => 'Số điện thoại phải có từ 9 đến 11 chữ số.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
        
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        
            're_password.required' => 'Vui lòng nhập lại mật khẩu.',
            're_password.same' => 'Mật khẩu nhập lại không khớp.',
        ]);
        

        // Tạo tài khoản mới
        $user = User::create([
            'name' =>$request->name ,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'avatar' => null,
            'note' => null,
            'role_id' => 3, // Mặc định là user bình thường
            'status' => 'active',
        ]);

        // Gửi email xác minh
        $user->sendEmailVerificationNotification();

        auth()->login($user);
        return redirect()->route('verification.notice');
    }
}
