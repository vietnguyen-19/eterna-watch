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
        $banners = Banner::orderByDesc('id')->get();
        return view('admin.banners.index', [
            'banners' => $banners
        ]);
    }


    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $request->validate([
                'title' => 'nullable|string|max:255',
                'position' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                'link' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'required|boolean',
            ]);

            // Lấy dữ liệu trừ image
            $data = $request->except('image');

            // Xử lý ảnh nếu có upload ảnh
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');

                // Tạo tên file mới
                $fileName = uniqid('banner_') . '.' . $image->getClientOriginalExtension();

                // Đường dẫn thư mục lưu ảnh: public/storage/banners
                $destinationPath = public_path('storage/banners');

                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Di chuyển file vào thư mục
                $image->move($destinationPath, $fileName);

                // Lưu đường dẫn ảnh vào data
                $data['image'] = '/banners/' . $fileName;
            }

            // Tạo mới banner
            Banner::create($data);

            return redirect()->route('admin.banners.index')->with('thongbao', [
                'type' => 'success',
                'message' => 'Thêm mới banner thành công!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('thongbao', [
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

    public function update(Request $request, $id)
    {

        try {
            // Tìm banner theo ID
            $banner = Banner::findOrFail($id);

            // Validate dữ liệu đầu vào
            $request->validate([
                'title' => 'nullable|string|max:255',
                'position' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                'link' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'required|boolean',
            ]);

            // Lấy dữ liệu trừ image
            $data = $request->except('image');

            // Xử lý ảnh nếu có upload ảnh mới
            if ($request->hasFile('image') && $request->file('image')->isValid()) {

                $image = $request->file('image');

                // Xóa ảnh cũ (nếu có)
                if (!empty($banner->image)) {
                    $oldImagePath = public_path(str_replace('/storage/', 'storage/', $banner->image));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Xóa file cũ
                    }
                }

                // Tạo tên file mới
                $fileName = uniqid('banner_') . '.' . $image->getClientOriginalExtension();

                // Đường dẫn thư mục lưu ảnh: public/storage/banners
                $destinationPath = public_path('storage/banners');

                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Di chuyển file vào thư mục
                $image->move($destinationPath, $fileName);

                // Cập nhật đường dẫn vào DB
                $banner->image = '/banners/' . $fileName;
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
        try {
            $banners = Banner::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
            return view('admin.banners.trash', compact('banners'));
        } catch (\Exception $e) {
            return redirect()->route('admin.banners.index')->with('thongbao', [
                'type' => 'danger',
                'message' => 'Lỗi khi tải thùng rác: ' . $e->getMessage()
            ]);
        }
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

            // Xóa ảnh vật lý nếu có
            if (!empty($banner->image)) {
                $imagePath = public_path(str_replace('/storage/', 'storage/', $banner->image));
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Xóa vĩnh viễn khỏi CSDL
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

    public function toggleStatus(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $request->validate([
                'id' => 'required|exists:banners,id',
                'is_active' => 'required|boolean'
            ]);

            // Tìm và cập nhật banner
            $banner = Banner::findOrFail($request->id);
            $banner->update(['is_active' => $request->is_active]);

            // Trả về response JSON
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'is_active' => $banner->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
