<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $data = Attribute::with('attributeValues')->get();
        return view('admin.attributes.index', compact('data'));
    }
    public function create()
    {
        $attribute = Attribute::with('attributeValues')->get();
        return view('admin.attributes.create', compact('attribute'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'attribute_name' => 'required|string|max:255',
        ]);

        $attribute = new Attribute();
        $attribute->attribute_name = $request->attribute_name;
        $attribute->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Thuộc tính đã được thêm thành công!',
            'data' => $attribute
        ]);
    }


    public function edit($id)
    {
        $att = Attribute::whereNull('parent_id')->get();
        $item = Attribute::findOrFail($id);  // Lấy danh mục theo ID
        return view('admin.att.edit', compact('att', 'item'));
    }
    public function update(Request $request)
    {
        $attribute = Attribute::find($request->id);
        if ($attribute) {
            $attribute->attribute_name = $request->attribute_name;
            $attribute->save();
            return response()->json(['status' => 'success', 'message' => 'Cập nhật thuộc tính thành công!', 'data' => $attribute]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy thuộc tính!']);
        }
    }


    public function destroy($id)
    {
        $attribute = Attribute::find($id);
        if ($attribute) {
            $attribute->delete();
            return response()->json(['status' => 'success', 'message' => 'Xóa thuộc tính thành công!']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy thuộc tính!']);
        }
    }
}
