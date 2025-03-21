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

        return redirect()->route('admin.categories.index')->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Danh mục đã được cập nhật thành công.',
            ]
        ]);
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
