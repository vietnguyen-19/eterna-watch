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

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/banners', $imageName);

            // Lưu thông tin Banner vào cơ sở dữ liệu
            $banner = new Banner();
            $banner->image_link = 'storage/banners/' . $imageName;

            // Lưu redirect_link nếu có
            if ($request->has('redirect_link')) {
                $banner->redirect_link = $request->input('redirect_link');
            }

            $banner->save();

            return redirect()->route('admin.banners.index')->with('thongbao', [
                'type' => 'success',
                'message' => 'Thêm mới Banner thành công!'
            ]);
        }

        return redirect()->back()->with('error', '⚠️ Không có file nào được tải lên!');
    }


    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(BannerUpdateRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if (!empty($banner->image_link)) {
                $oldImagePath = str_replace('storage/', 'public/', $banner->image_link);
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/banners', $imageName);
            $data['image_link'] = 'storage/banners/' . $imageName;
        }

        // Cập nhật redirect_link nếu có
        if ($request->has('redirect_link')) {
            $data['redirect_link'] = $request->input('redirect_link');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('thongbao', [
            'type' => 'success',
            'message' => 'Cập nhật banner thành công!'
        ]);
    }



  public function destroy($id)
{
    $banner = Banner::findOrFail($id);

    if (!empty($banner->image_link)) {
        $imagePath = public_path($banner->image_link);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $banner->delete();

    return redirect()->route('admin.banners.index')->with('thongbao', [
        'type' => 'danger',
        'message' => 'Banner đã bị xóa thành công!'
    ]);
}


}
