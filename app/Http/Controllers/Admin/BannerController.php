<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Requests\BannerStoreRequest;
use App\Http\Requests\BannerUpdateRequest;

class BannerController extends Controller
{
    public function index()
    {
        // Lấy danh sách banners và sắp xếp theo ID mới nhất
        $banners = Banner::orderBy('id', 'desc')->get();

        return view('admin.banners.index', compact('banners'));
    }


    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(BannerStoreRequest $request)
    {
        Banner::create($request->validated());

        return redirect()->route('admin.banners.index')->with('success', 'Thêm mới thành công Banner');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(BannerUpdateRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $banner->update($request->validated());

        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật thành công Banner');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Xóa thành công');
    }

    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.show', compact('banner'));
    }
}
