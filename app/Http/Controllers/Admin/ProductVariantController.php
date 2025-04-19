<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute as ModelsAttribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductVariantController extends Controller
{

    public function create($id)
    {

        $product = Product::with('attributes.attributeValues', 'brand', 'category')->findOrFail($id);
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $attributes = Attribute::select('id', 'attribute_name')->get();
        // Trả về view cùng với dữ liệu
        return view('admin.product_variants.create', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
    public function edit($id)
    {
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $attributes = Attribute::select('id', 'attribute_name')->get();
        $allAttributeValues = AttributeValue::all()->groupBy('attribute_id');

        $product = Product::with('brand', 'category', 'variants.attributeValues.nameValue', 'attributes.attributeValues')->findOrFail($id);

        return view('admin.product_variants.edit', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
            'allAttributeValues' => $allAttributeValues,
        ]);
    }
    public function store(Request $request)
    {

        $data = $request->all();

        // Validate dữ liệu đầu vào
        $validator = Validator::make($data, [
            'productId' => 'required|exists:products,id',
            'variants.image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.sku' => 'required|string|unique:product_variants,sku',
            'variants.price' => 'required|numeric|min:0',
            'variants.stock' => 'required|integer|min:0',
            'variants.attributes' => 'required|array|min:1',
            'variants.attributes.*' => 'required|integer|exists:attribute_values,id',
        ], [
            'productId.required' => 'Vui lòng chọn sản phẩm.',
            'productId.exists' => 'Sản phẩm không tồn tại.',
            'variants.image.required' => 'Vui lòng chọn hình ảnh.',
            'variants.image.image' => 'Tệp tải lên phải là hình ảnh.',
            'variants.image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            'variants.image.max' => 'Hình ảnh không được vượt quá 2MB.',
            'variants.sku.required' => 'Vui lòng nhập mã SKU.',
            'variants.sku.unique' => 'SKU đã tồn tại.',
            'variants.price.required' => 'Vui lòng nhập giá.',
            'variants.price.numeric' => 'Giá phải là số.',
            'variants.stock.required' => 'Vui lòng nhập số lượng tồn.',
            'variants.stock.integer' => 'Số lượng tồn phải là số nguyên.',
            'variants.attributes.required' => 'Vui lòng chọn thuộc tính.',
            'variants.attributes.*.exists' => 'Giá trị thuộc tính không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('open_modal', true)
                ->withInput();
        }

        // ================================
        // ✅ Kiểm tra tổ hợp thuộc tính đã tồn tại chưa
        // ================================
        $productId = $data['productId'];
        $newAttributeValueIds = collect($data['variants']['attributes'])
            ->map(fn($val) => (int) $val)
            ->sort()
            ->values()
            ->all();

        $existingVariants = ProductVariant::where('product_id', $productId)->get();

        foreach ($existingVariants as $variant) {
            $existingAttributeValueIds = DB::table('variant_attributes')
                ->where('variant_id', $variant->id)
                ->pluck('attribute_value_id')
                ->map(fn($val) => (int) $val)
                ->sort()
                ->values()
                ->all();

            if ($newAttributeValueIds === $existingAttributeValueIds) {
                return redirect()->back()
                    ->with('error', 'Tổ hợp thuộc tính này đã tồn tại.')
                    ->withInput();
            }
        }

        DB::beginTransaction();
        try {
            // Xử lý hình ảnh
            $imagePath = null;
            $imageName = null;

            if ($request->hasFile('variants.image')) {
                $image = $request->file('variants.image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('storage/product_variants');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $image->move($destinationPath, $imageName);
            }

            // Lưu biến thể
            $variant = new ProductVariant();
            $variant->product_id = $productId;
            $variant->sku = $data['variants']['sku'];
            $variant->price = $data['variants']['price'];
            $variant->stock = $data['variants']['stock'];
            $variant->status = 1;
            $variant->image = 'product_variants/' . $imageName;
            $variant->created_at = now();
            $variant->updated_at = now();
            $variant->save();

            // Lưu thuộc tính
            foreach ($data['variants']['attributes'] as $attributeId => $attributeValueId) {
                DB::table('variant_attributes')->insert([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $attributeValueId,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.products.show', $productId)
                ->with('success', 'Thêm biến thể thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
            ->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage())
            ->with('open_modal', true);
        }
    }
    public function storeMany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'variants' => 'required|array',
            'variants.*.name_value_ids' => 'required|array',
            'variants.*.sku' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.image' => 'required|string|max:255',
        ], [
            'variants.required' => 'Vui lòng thêm ít nhất một biến thể sản phẩm.',
            'variants.array' => 'Dữ liệu biến thể không hợp lệ.',

            'variants.*.name_value_ids.required' => 'Vui lòng chọn thuộc tính cho biến thể.',
            'variants.*.name_value_ids.array' => 'Thuộc tính biến thể không hợp lệ.',

            'variants.*.sku.required' => 'Vui lòng nhập mã SKU cho biến thể.',
            'variants.*.sku.string' => 'Mã SKU phải là chuỗi ký tự.',
            'variants.*.sku.max' => 'Mã SKU không được vượt quá :max ký tự.',

            'variants.*.price.required' => 'Vui lòng nhập giá cho biến thể.',
            'variants.*.price.numeric' => 'Giá phải là một số hợp lệ.',
            'variants.*.price.min' => 'Giá phải lớn hơn hoặc bằng :min.',

            'variants.*.stock.required' => 'Vui lòng nhập số lượng tồn kho.',
            'variants.*.stock.integer' => 'Tồn kho phải là một số nguyên.',
            'variants.*.stock.min' => 'Tồn kho không được nhỏ hơn :min.',

            'variants.*.image.required' => 'Vui lòng chọn hình ảnh cho biến thể.',
            'variants.*.image.string' => 'Dữ liệu hình ảnh không hợp lệ.',
            'variants.*.image.max' => 'Đường dẫn hình ảnh không được vượt quá :max ký tự.',
        ]);

        if ($validator->fails()) {
            $variantsOld = $request->input('variants', []);
            $nameValues = [];

            foreach ($variantsOld as $variant) {
                if (!empty($variant['name_value_ids'])) {
                    foreach ($variant['name_value_ids'] as $id) {
                        $nameValue = AttributeValue::find($id);
                        if ($nameValue) {
                            $nameValues[$id] = $nameValue->value_name;
                        }
                    }
                }
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('nameValues', $nameValues);
        }

        $validated = $validator->validated();

        try {
            DB::beginTransaction();

            foreach ($validated['variants'] as $variant) {
                $productVariant = ProductVariant::create([
                    'product_id' => $request->productId,
                    'sku' => $variant['sku'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'],
                    'image' => $variant['image'],
                    'status' => 'in_stock'
                ]);

                foreach ($variant['name_value_ids'] as $attribute) {
                    DB::table('variant_attributes')->insert([
                        'variant_id' => $productVariant->id,
                        'attribute_value_id' => $attribute,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.products.show', $request->productId)
                ->with('success', 'Biến thể sản phẩm đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi lưu biến thể: ' . $e->getMessage());
        }
    }




    public function update(Request $request, $productId)
    {
        $validated = $request->validate([
            'productId' => 'required|exists:products,id',
            'sku.*' => 'required|string|max:255',
            'price.*' => 'required|numeric|min:0',
            'stock.*' => 'required|integer|min:0',
            'attributes.*' => 'required|array',
            'attributes.*.*' => 'required|exists:attribute_values,id',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'productId.required' => 'Vui lòng cung cấp ID sản phẩm.',
            'productId.exists' => 'Sản phẩm không tồn tại.',
            'sku.*.required' => 'Vui lòng nhập mã SKU cho biến thể.',
            'sku.*.string' => 'Mã SKU phải là chuỗi ký tự.',
            'sku.*.max' => 'Mã SKU không được vượt quá 255 ký tự.',
            'price.*.required' => 'Vui lòng nhập giá cho biến thể.',
            'price.*.numeric' => 'Giá phải là số.',
            'price.*.min' => 'Giá không được nhỏ hơn 0.',
            'stock.*.required' => 'Vui lòng nhập số lượng tồn kho cho biến thể.',
            'stock.*.integer' => 'Số lượng tồn kho phải là số nguyên.',
            'stock.*.min' => 'Số lượng tồn kho không được nhỏ hơn 0.',
            'attributes.*.required' => 'Vui lòng cung cấp thuộc tính cho biến thể.',
            'attributes.*.array' => 'Thuộc tính phải là một mảng.',
            'attributes.*.*.required' => 'Vui lòng chọn giá trị thuộc tính cho biến thể.',
            'attributes.*.*.exists' => 'Giá trị thuộc tính không hợp lệ.',
            'image.*.image' => 'File tải lên phải là hình ảnh.',
            'image.*.mimes' => 'Hình ảnh chỉ hỗ trợ định dạng jpeg, png, jpg, gif.',
            'image.*.max' => 'Hình ảnh không được lớn hơn 2MB.',
        ]);

        // Ensure productId matches
        if ($request->productId != $productId) {
            return redirect()->back()->with('error', 'Invalid product ID.');
        }
       
        DB::beginTransaction();

        try {
            $data = $request->only(['sku', 'price', 'stock', 'attributes', 'image','productId']);
            $productId = $data['productId'];

            if (isset($data['attributes']) && is_array($data['attributes'])) {
                foreach ($data['attributes'] as $variantId => $attributes) {
                    $variantData = [
                        'sku'   => $data['sku'][$variantId],
                        'price' => $data['price'][$variantId],
                        'stock' => $data['stock'][$variantId],
                    ];

                    // Kiểm tra nếu có file ảnh mới
                    if ($request->hasFile("image.$variantId") && $request->file("image.$variantId")->isValid()) {
                        $image = $request->file("image.$variantId");

                        // Lấy đường dẫn ảnh cũ từ CSDL
                        $oldImage = ProductVariant::where('id', $variantId)->value('image');

                        // Xóa ảnh cũ nếu tồn tại
                        if ($oldImage) {
                            $oldImagePath = storage_path('app/public/' . $oldImage);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }

                        // Tạo tên ảnh mới
                        $fileName = time() . '_' . $variantId . '.' . $image->getClientOriginalExtension();

                        // Định nghĩa thư mục đích
                        $destinationPath = storage_path('app/public/product_variants');

                        // Tạo thư mục nếu chưa tồn tại
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }

                        // Lưu ảnh vào storage bằng PHP thuần
                        $image->move($destinationPath, $fileName);

                        // Cập nhật đường dẫn ảnh trong CSDL
                        $variantData['image'] = 'product_variants/' . $fileName;
                    }

                    // Cập nhật biến thể
                    ProductVariant::where('id', $variantId)->update($variantData);

                    // Xóa và thêm lại thuộc tính
                    VariantAttribute::where('variant_id', $variantId)->delete();
                    foreach ($attributes as $attributeValueId) {
                        VariantAttribute::create([
                            'variant_id' => $variantId,
                            'attribute_value_id' => $attributeValueId
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products.show', $productId)->with('success', 'Cập nhật biến thể sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
            ->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage())
            ->with('close_modal', true);
        }
    }

    public function destroy($id)
    {
        $variant = ProductVariant::with('product')->findOrFail($id);
        $productId = $variant->product->id;
        $variant->delete();
        return redirect()->route('admin.productvariants.edit', $productId)->with('success', 'Xóa biến thể thành công');
    }
}
