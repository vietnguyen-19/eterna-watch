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
        $categories = Category::with('children')->where('parent_id', null)->latest('id')->get();
        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create(Request $request)
    {
        $type = $request->query('type');
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories', 'type'));
    }
    public function store(Request $request)
    {
        // ✅ VALIDATE đưa ra ngoài try-catch
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => empty($request->parent_id)
                ? 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
                : 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là chuỗi.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là active hoặc inactive.',
            'parent_id.exists' => 'Danh mục cha không tồn tại.',
            'image.required' => 'Hình ảnh là bắt buộc với danh mục gốc.',
            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpg, jpeg, png, hoặc gif.',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('storage/categories'), $imageName);
                $imagePath = 'categories/' . $imageName;
            }

            Category::create([
                'name' => $request->name,
                'image' => $imagePath,
                'parent_id' => $request->filled('parent_id') ? (int)$request->parent_id : null,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra khi thêm danh mục: ' . $e->getMessage());
        }
    }


    public function edit(Request $request, $id)
    {
        $type = $request->query('type'); // Lấy giá trị type từ URL query (?type=...)
        $categories = Category::whereNull('parent_id')->get();
        $item = Category::findOrFail($id);  // Lấy danh mục theo ID
        return view('admin.categories.edit', compact('categories', 'item', 'type'));
    }

    public function update(Request $request, $id)
    {
        // Validate dữ liệu trước
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', // Kiểm tra tồn tại danh mục cha
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Hình ảnh phải là một file ảnh và kích thước tối đa là 2MB
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'parent_id.exists' => 'Danh mục cha không tồn tại.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là Active hoặc Inactive.',
            'image.image' => 'File tải lên phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpg, jpeg, png, hoặc gif.',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',
        ]);

        try {
            // Tìm danh mục theo ID
            $category = Category::find($id);

            // Kiểm tra nếu có ảnh mới được upload
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có
                if ($category->image) {
                    $oldImagePath = public_path('storage/categories/' . $category->image);
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
        try {
            $category = Category::findOrFail($id);

            if ($category->parent_id === null) {
                $category->children->each(function ($child) {
                    $child->delete();
                });
            }

            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được chuyển vào thùng rác.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Không thể xóa danh mục: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        // Deleted parent categories (load only deleted children as well)
        $deletedParentCategories = Category::onlyTrashed()
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->onlyTrashed(); // Chỉ lấy các danh mục con đã bị xóa
            }])
            ->get();

        // Deleted child categories (đề phòng bạn cần tách riêng)
        $deletedChildCategories = Category::onlyTrashed()
            ->whereNotNull('parent_id')
            ->whereHas('parent', function ($query) {
                $query->whereNull('deleted_at'); // Chỉ lấy những danh mục cha chưa bị xóa
            })
            ->get();


        return view('admin.categories.trash', compact('deletedParentCategories', 'deletedChildCategories'));
    }
    public function restore($id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);

            if ($category->parent_id === null) {
                $category->children()->withTrashed()->each(function ($child) {
                    $child->restore();
                });
            }

            $category->restore();

            return redirect()->back()->with('success', 'Danh mục đã được khôi phục thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể khôi phục danh mục: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);

            if ($category->parent_id === null) {
                $category->children()->withTrashed()->each(function ($child) {
                    $child->forceDelete();
                });

                if ($category->image) {
                    $imagePath = public_path('storage/' . $category->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }

            $category->forceDelete();

            return redirect()->back()->with('success', 'Danh mục đã bị xóa vĩnh viễn.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể xóa vĩnh viễn danh mục: ' . $e->getMessage());
        }
    }
}
