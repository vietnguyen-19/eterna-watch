<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ClientSettingsController extends Controller
{
    public function index()
    {
        // Lấy cài đặt mặc định từ database, nếu không có thì tạo mới
        $setting = Setting::firstOrNew(['id' => 2]); // Dùng id khác với admin (ví dụ: 2 cho client)
        return view('client.settings_user', compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'language' => 'required|in:vi,en',
            'notification_email' => 'boolean',
            'notification_sms' => 'boolean',
            'notification_app' => 'boolean',
            'privacy_profile' => 'required|in:public,friends,private',
            'privacy_contact' => 'required|in:public,friends,private',
            'theme' => 'required|in:light,dark',
            'layout' => 'required|in:default,compact,wide'
        ]);

        $setting = Setting::updateOrCreate(
            ['id' => 2], // Cài đặt mặc định cho client
            $request->only([
                'language',
                'notification_email',
                'notification_sms',
                'notification_app',
                'privacy_profile',
                'privacy_contact',
                'theme',
                'layout'
            ])
        );

        return redirect()->back()->with('success', 'Cài đặt đã được cập nhật!');
    }
}