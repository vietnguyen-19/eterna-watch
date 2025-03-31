<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\Settings;
use Illuminate\Http\Request;
use Auth;

class AdminSettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        if ($user->is_admin) { // Giả sử bạn có một cột `is_admin` trong bảng users
            // Hiển thị thông tin cài đặt cho admin
            return view('settings.admin_edit', compact('user'));
        }
        return view('settings.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:15',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $user->image = $path;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect()->route('settings.edit')->with('status', 'Cài đặt đã được cập nhật!');
    }
}
