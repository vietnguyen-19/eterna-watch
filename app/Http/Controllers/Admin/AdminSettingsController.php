<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;

class AdminSettingsController extends Controller
{
    // Hiển thị form cài đặt
    public function index()
    {
        $setting = Setting::firstOrNew(['id' => 1]);
        return view('admin.settings.index', compact('setting'));
    }

    
    // Lưu cài đặt người dùng
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
            ['user_id' => 1],
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


    // Admin cập nhật cài đặt mặc định
    public function adminUpdate(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Bạn không có quyền!');
        }

        // Logic cập nhật cài đặt mặc định cho toàn hệ thống
        Setting::whereNull('user_id')->update([
            'language' => $request->default_language,
            'theme' => $request->default_theme,
            // Thêm các cài đặt mặc định khác
        ]);

        return redirect()->back()->with('success', 'Cài đặt mặc định đã được cập nhật!');
    }  
}
