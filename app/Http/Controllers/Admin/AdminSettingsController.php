<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\SettingsAdmin;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // Lấy tất cả các cài đặt từ cơ sở dữ liệu
        $settings = SettingsAdmin::pluck('value', 'key'); // Lấy giá trị theo key

        return view('admin.settings_admin', compact('settings'));
    }

    public function update(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
        ]);

        // Cập nhật hoặc tạo mới các cài đặt
        Setting::updateOrCreate(['key' => 'site_name'], ['value' => $request->site_name]);
        Setting::updateOrCreate(['key' => 'contact_email'], ['value' => $request->contact_email]);

        return redirect()->route('admin.settings')->with('success', 'Cài đặt đã được cập nhật!');
    }
}
