<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BannerStoreRequest;
use App\Http\Requests\BannerUpdateRequest;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('id', 'desc')->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(BannerStoreRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/banners', $imageName);
                $data['image_link'] = 'storage/banners/' . $imageName;
            }

            Banner::create($data);

            return redirect()->route('admin.banners.index')->with('thongbao', [
                'type' => 'success',
                'message' => 'Thêm banner thành công!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('thongbao', [
                'type' => 'danger',
                'message' => 'Lỗi: ' . $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(BannerUpdateRequest $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $data = $request->validated();

            if ($request->hasFile('image')) {
                // Xóa ảnh cũ
                if ($banner->image_link) {
                    $oldImagePath = str_replace('storage/', 'public/', $banner->image_link);
                    Storage::delete($oldImagePath);
                }

                // Lưu ảnh mới
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/banners', $imageName);
                $data['image_link'] = 'storage/banners/' . $imageName;
            }

            $banner->update($data);

            return redirect()->route('admin.banners.index')->with('thongbao', [
                'type' => 'success',
                'message' => 'Cập nhật banner thành công!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('thongbao', [
                'type' => 'danger',
                'message' => 'Lỗi: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $banner->delete();

            return redirect()->route('admin.banners.index')->with('thongbao', [
                'type' => 'success',
                'message' => 'Đã chuyển banner vào thùng rác!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('thongbao', [
                'type' => 'danger',
                'message' => 'Lỗi: ' . $e->getMessage()
            ]);
        }
    }

    public function trash()
    {
        $banners = Banner::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.banners.trash', compact('banners'));
    }

    public function restore($id)
    {
        try {
            $banner = Banner::onlyTrashed()->findOrFail($id);
            $banner->restore();

            return redirect()->route('admin.banners.trash')->with('thongbao', [
                'type' => 'success',
                'message' => 'Khôi phục banner thành công!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('thongbao', [
                'type' => 'danger',
                'message' => 'Lỗi: ' . $e->getMessage()
            ]);
        }
    }

    public function forceDelete($id)
    {
        try {
            $banner = Banner::onlyTrashed()->findOrFail($id);

            // Xóa ảnh vật lý
            if ($banner->image_link) {
                $imagePath = str_replace('storage/', 'public/', $banner->image_link);
                Storage::delete($imagePath);
            }

            $banner->forceDelete();

            return redirect()->route('admin.banners.trash')->with('thongbao', [
                'type' => 'success',
                'message' => 'Xóa vĩnh viễn banner thành công!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('thongbao', [
                'type' => 'danger',
                'message' => 'Lỗi: ' . $e->getMessage()
            ]);
        }
    }
}
