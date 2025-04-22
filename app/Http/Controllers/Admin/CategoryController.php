<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = Category::query()->latest('id')->get();
        return view('admin.categories.index', [
            'data' => $data,
        ]);
    }
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }
    public function store(CategoryStoreRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.categories.index')->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Danh mục đã được tạo thành công.',
            ]
        ]);
    }
    public function edit($id)
    {
        $categories = Category::whereNull('parent_id')->get();
        $item = Category::findOrFail($id);  // Lấy danh mục theo ID
        return view('admin.categories.edit', compact('categories', 'item'));
    }
    public function update(CategoryUpdateRequest $request, $id)
    {
        // Tìm danh mục theo ID
        $category = Category::findOrFail($id);


        $category->update([
            'name' => $request->name ?? $category->name,
            'parent_id' => $request->parent_id ?? $category->parent_id,
            'status' => $request->status ?? $category->status,
        ]);
        try {
            // Tìm danh mục theo ID
            $category = Category::find($id);

            // Kiểm tra nếu có ảnh mới được upload
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có
                if ($category->image) {
                    $oldImagePath = public_path('storage/' . $category->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Xóa ảnh cũ khỏi thư mục
                    }
                }

                // Lưu ảnh mới vào thư mục public/storage/categories
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('storage/categories/') . $imageName;

                // Di chuyển ảnh vào thư mục
                $image->move(public_path('storage/categories'), $imageName);

                // Cập nhật đường dẫn ảnh vào cơ sở dữ liệu
                $category->image = 'categories/' . $imageName;
            }

            // Cập nhật các trường khác của danh mục
            $category->name = $request->name ?? $category->name;
            $category->parent_id = $request->parent_id ?? $category->parent_id;
            $category->status = $request->status ?? $category->status;

            // Lưu thông tin danh mục
            $category->save();

            // Trả về thông báo thành công
            return redirect()->route('admin.categories.index')->with('success', 'Sửa danh mục thành công');
        } catch (\Exception $e) {
            // Trường hợp có lỗi trong quá trình xử lý
            return redirect()->route('admin.categories.index')->with('error', 'Có lỗi xảy ra trong quá trình cập nhật danh mục. Vui lòng thử lại.');
        }

    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);  // Tìm danh mục theo ID

        // Xóa danh mục
        $category->delete();

        return redirect()->route('admin.categories.index')->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Danh mục đã được xóa thành công.',
            ]
        ]);
    }
}
