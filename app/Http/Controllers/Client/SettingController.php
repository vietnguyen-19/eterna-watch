<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function contactUs()
    {
        return view('client.contact_us');
    }
    public function aboutUs()
    {
        $about = config('about_us'); // Lấy dữ liệu từ config
        return view('client.about_us', compact('about'));
    }
    public function contactStore(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng.',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
        ]);

        // Nếu xác thực thất bại, trả về lỗi
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        try {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'status' => 'pending', // Giá trị mặc định từ schema
                'sent_at' => now(),    // Timestamp hiện tại
            ]);

            return redirect()->back()->with('success', 'Tin nhắn của bạn đã được gửi thành công! Chúng tôi sẽ trả lời bạn trong thời gian sớm nhất!');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại!')
                            ->withInput();
        }
    }
}
