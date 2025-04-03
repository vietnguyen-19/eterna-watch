<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingUpdateRequest;
use App\Http\Requests\SettingStoreRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::get();
        dd($settings);
        return view('admin.settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.settings.create');
        
    }

    public function store(SettingStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::check() ? Auth::id() : null; // Nếu không đăng nhập, user_id là NULL
        $setting = Setting::create($data);
        return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
    }


    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(SettingUpdateRequest $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $data = $request->validated();
        $data['user_id'] = Auth::check() ? Auth::id() : null; // Nếu không đăng nhập, user_id là NULL
        $setting->update($data);
        return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();
        return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
    }
    
}
