<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();

        return view('admin.banners.index', compact('banners'));
    }



    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_link' => 'required|string',
            'redirect_link' => 'nullable|string',
        ]);

        Banner::create($request->all());

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');

    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        // Lấy bản ghi banner
        $banner = Banner::findOrFail($id);

        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'image_link' => 'required|string|url', // Đảm bảo đây là URL hợp lệ
            'redirect_link' => 'nullable|string|url', // URL hoặc null
        ]);

        // Cập nhật dữ liệu
        $banner->update([
            'image_link' => $request->input('image_link'),
            'redirect_link' => $request->input('redirect_link'),
        ]);

        // Quay lại danh sách với thông báo thành công
        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');

    }


    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');

    }
    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.show', compact('banner'));
    }
}
