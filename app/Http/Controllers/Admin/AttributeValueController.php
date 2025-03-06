<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttributeValueController extends Controller
{
    public function index($id)
    {
        $attribute = Attribute::with('attributeValues')->findOrFail($id);
        return view('admin.attributes.index_detail', compact('attribute'));
    }

    public function create($id)
    {
        $attribute = Attribute::with('attributeValues')->findOrFail($id);
        return view('admin.attributes.create_detail', compact('attribute'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|integer',
            'value_name' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value_name' => $request->value_name,
            'note' => $request->note,
        ]);
        return redirect()->route('admin.attribute_values.index', $request->attribute_id)->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Giá trị thuộc tính đã được thêm mới thành công.',
            ]
        ]);
    }
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'id' => 'required',
            'value_name' => 'required|max:255',
            'note' => 'nullable|max:255',
        ]);
    
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->update([
            'value_name' => $request->value_name,
            'note' => $request->note,
        ]);
    
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $attributeValue = AttributeValue::with('attribute')->findOrFail($id);
        return view('admin.attributes.edit_detail', compact('attributeValue'));
    }
    public function destroy($id)
    {
        try {
            $attributeValue = AttributeValue::select('id', 'attribute_id')->findOrFail($id);
            $attributeValue->delete();
            return redirect()->route('admin.attribute_values.index', $attributeValue->attribute_id)->with([
                'thongbao' => [
                    'type' => 'success',
                    'message' => 'Giá trị thuộc tính đã được xóa thành công.',
                ]
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.attribute_values.index')->with([
                'thongbao' => [
                    'type' => 'danger',
                    'message' => 'Đã xảy ra lỗi khi xóa giá trị thuộc tính. Vui lòng thử lại sau.',
                ]
            ]);
        }
    }
}
