<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Lọc theo tên thương hiệu
        $query = Brand::query();
        if ($search) {
            $filteredBrands = $query->where('name', 'like', "%$search%")->get();
            
            // Nếu không tìm thấy, trả về tất cả thương hiệu và hiển thị thông báo
            if ($filteredBrands->isEmpty()) {
                return redirect()->route('admin.brands.index')
                    ->with('success', "Không tìm thấy thương hiệu '$search'. Danh sách hiển thị tất cả.");
            }
        }

        $brands = $query->paginate(10);

        return view('admin.brands.index', compact('brands'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //hiển thị form thêm mới
        $brands = Brand::all();
        return view('admin.brands.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //them du lieu
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:brands,id',
        ]);
        Brand::create($request->all());
        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã được thêm');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brands = Brand::all();
        return view('admin.brands.edit', compact('brand', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:brands,id',
        ]);
        $brand = Brand::findOrFail($id);

        $brand->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id ?? null,
        ]);
        return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã bị xóa');
    }
}
