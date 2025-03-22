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
       
        DB::beginTransaction();

        // Lấy dữ liệu từ request, loại bỏ _token
        $data = $request->except('_token');

        // Lấy mảng variants từ request
        $variantsData = $data['variants'] ?? [];

        // Lặp qua từng variant
        foreach ($variantsData as $index => $variant) {
            // Xây dựng mảng dữ liệu variant
            $variantData = [
                'product_id'   => $data['productId'],
                'sku'   => $variant['sku'],
                'price' => $variant['price'],
                'stock' => $variant['stock'],
                'image' => $variant['image'],
            ];


            // Tạo bản ghi cho biến thể sản phẩm
            $productVariant = ProductVariant::create($variantData);
            $productVariantId = $productVariant->id;

            if (isset($variant['name_value_ids']) && is_array($variant['name_value_ids'])) {
                foreach ($variant['name_value_ids'] as $valueId) {
                   VariantAttribute::create([
                        'variant_id'         => $productVariantId,
                        'attribute_value_id' => $valueId
                    ]);
                }
            }
           
        }

        DB::commit();
        return redirect()->route('admin.products.show',$data['productId'])->with([
            'thongbao' => [
                'type'    => 'success',
                'message' => 'Sản phẩm đã được tạo thành công.',
            ]
        ]);
    }

    public function update(Request $request, $productId)
    {
        DB::beginTransaction();

        // Lấy dữ liệu từ request, loại bỏ _token
        $data = $request->except('_token', '_method');
        $productId = $data['productId'];

        // === CẬP NHẬT CÁC BIẾN THỂ CŨ ===
        if (isset($data['attributes']) && is_array($data['attributes'])) {
            foreach ($data['attributes'] as $variantId => $attributes) {
                $variantData = [
                    'sku'   => $data['sku'][$variantId],
                    'price' => $data['price'][$variantId],
                    'stock' => $data['stock'][$variantId],
                ];

                // Xử lý cập nhật ảnh cho biến thể cũ
                if ($request->hasFile("image.$variantId")) {
                    $image = $request->file("image.$variantId");

                    // Lấy ảnh cũ từ database
                    $oldImage = ProductVariant::where('id', $variantId)->value('image');

                    // Xóa ảnh cũ nếu tồn tại
                    if ($oldImage && file_exists(storage_path('app/public/' . $oldImage))) {
                        unlink(storage_path('app/public/' . $oldImage));
                    }

                    // Tạo tên file mới
                    $fileName = time() . $variantId . '.' . $image->getClientOriginalExtension();
                    $destinationPath = storage_path('app/public/products');

                    // Tạo thư mục nếu chưa tồn tại
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    // Lưu ảnh mới
                    $image->move($destinationPath, $fileName);
                    $variantData['image'] = 'products/' . $fileName;
                }

                // Cập nhật biến thể
                ProductVariant::where('id', $variantId)->update($variantData);

                // Xóa tất cả các thuộc tính cũ trước khi thêm mới
                VariantAttribute::where('variant_id', $variantId)->delete();

                // Thêm lại các thuộc tính mới
                foreach ($attributes as $attributeValueId) {
                    VariantAttribute::create([
                        'variant_id' => $variantId,
                        'attribute_value_id' => $attributeValueId
                    ]);
                }
            }
        }
        // === THÊM MỚI CÁC BIẾN THỂ ===
        if (isset($data['variants']['new']) && is_array($data['variants']['new'])) {
            foreach ($data['variants']['new'] as $index => $newVariant) {
                $newVariantData = [
                    'product_id' => $productId,
                    'sku'   => $newVariant['sku'],
                    'price' => $newVariant['price'],
                    'stock' => $newVariant['stock'],
                ];

                // Xử lý ảnh cho biến thể mới
                if ($request->hasFile("variants.new.$index.image")) {
                    $images = $request->file("variants.new.$index.image");

                    // Nếu chỉ có một ảnh, Laravel vẫn trả về dưới dạng mảng
                    if (is_array($images)) {
                        foreach ($images as $image) {
                            if ($image->isValid()) {
                                $fileName = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                                $destinationPath = storage_path('app/public/products');

                                // Tạo thư mục nếu chưa tồn tại
                                if (!file_exists($destinationPath)) {
                                    mkdir($destinationPath, 0777, true);
                                }

                                $image->move($destinationPath, $fileName);
                                $newVariantData['image'] = 'products/' . $fileName;
                            }
                        }
                    } else {
                        // Trường hợp chỉ có một ảnh
                        if ($images->isValid()) {
                            $fileName = time() . rand(1000, 9999) . '.' . $images->getClientOriginalExtension();
                            $destinationPath = storage_path('app/public/products');

                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0777, true);
                            }

                            $images->move($destinationPath, $fileName);
                            $newVariantData['image'] = 'products/' . $fileName;
                        }
                    }
                }

                // Tạo mới biến thể
                $productVariant = ProductVariant::create($newVariantData);

                // Thêm thuộc tính cho biến thể mới
                if (isset($newVariant['attributes']) && is_array($newVariant['attributes'])) {
                    foreach ($newVariant['attributes'] as $attributeValueId) {
                        VariantAttribute::create([
                            'variant_id' => $productVariant->id,
                            'attribute_value_id' => $attributeValueId
                        ]);
                    }
                }
            }
        }
        DB::commit();

        // Redirect về trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('admin.products.show', $productId)->with([
            'thongbao' => [
                'type'    => 'success',
                'message' => 'Sản phẩm đã được tạo thành công.',
            ]
        ]);
    }
    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);

        // Thực hiện xóa
        $variant->delete();

        // Trả về phản hồi JSON
        return response()->json(['success' => 'Xóa biến thể thành công!']);
    }
}
