<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingUpdateRequest;
use App\Http\Requests\SettingStoreRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class SettingController extends Controller
{
    public function index()
    {

        $setting = DB::table('settings')->get();
         //$setting = Setting::all();
         //return view('admin.settings.index', compact('settings'));
        return view('admin.settings.index')->with(['setting' => $setting]);

    }

    public function create()
    {   
        $settings = Setting::all();
        
        return view('admin.settings.create', compact('settings'));
        //return redirect()->route('admin.settings.index')->with('success', 'Thêm cài đặt thành công!');

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
