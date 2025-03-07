<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductHasAttribute;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with('brand', 'category')->latest('id')->get();
        return view('admin.products.index', [
            'data' => $data,
        ]);
    }
    public function create()
    {

        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $attributes = Attribute::select('id', 'attribute_name')->get();
        $results = AttributeValue::orderBy('attribute_id')->orderBy('id')->get();

        return view('admin.products.create', [
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
        ]);
    }

    public function show($id)
    {
        $data = Product::with('brand', 'category', 'variants.attributeValues.nameValue', 'attributes.attributeValues')->findOrFail($id);
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $attributes = Attribute::select('id', 'attribute_name')->get();

        return view('admin.products.show', [
            'data' => $data,
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
        ]);
    }

    public function edit($id)
    {
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $attributes = Attribute::select('id', 'attribute_name')->get();
        $allAttributeValues = AttributeValue::all()->groupBy('attribute_id');

        $data = Product::with('brand', 'category', 'variants.attributeValues.nameValue', 'attributes')->findOrFail($id);

        return view('admin.products.edit', [
            'data' => $data,
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
            'allAttributeValues' => $allAttributeValues,
        ]);
    }

    public function store(ProductStoreRequest $request)
    {

        DB::beginTransaction();


        // Khởi tạo mảng dữ liệu cho sản phẩm
        $productData = [
            'name' => $request->name,
            'price_default' => $request->price_default,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'status' => $request->status,
        ];
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = time() . '.' . $avatar->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/products');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $avatar->move($destinationPath, $fileName);
            $productData['avatar'] = 'products/' . $fileName;
        }


        // Tạo sản phẩm mới trong bảng products
        $product = Product::create($productData);

        // Kiểm tra nếu có attribute_values từ request
        if ($request->has('attribute_values') && is_array($request->attribute_values)) {
            // Lặp qua từng attribute_value và tạo mới trong bảng attributes
            foreach ($request->attribute_values as $attributeName) {
                $attribute = ProductHasAttribute::create([
                    'product_id' => $product->id,
                    'attribute_id' => $attributeName
                ]);
            }
        }

        // Lưu lại transaction
        DB::commit();

        // Redirect về trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('admin.productvariants.create', $product->id)->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        DB::beginTransaction();


        // Khởi tạo mảng dữ liệu cho sản phẩm
        $productData = [
            'name' => $request->name,
            'price_default' => $request->price_default,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'status' => $request->status,
        ];


        // Lấy thông tin sản phẩm cần cập nhật
        $product = Product::findOrFail($id);

        // Khởi tạo mảng dữ liệu cho sản phẩm
        $productData = [
            'name' => $productData['name'],
            'price_default' => $productData['price_default'],
            'short_description' => $productData['short_description'],
            'full_description' => $productData['full_description'],
            'category_id' => $productData['category_id'],
            'brand_id' => $productData['brand_id'],
            'status' => $productData['status'],
        ];

        // Xử lý cập nhật avatar (ảnh đại diện)
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            // Xóa avatar cũ nếu có
            if ($product->avatar && file_exists(storage_path('app/public/' . $product->avatar))) {
                unlink(storage_path('app/public/' . $product->avatar));
            }

            // Tạo tên file mới và lưu ảnh
            $fileName = time() . '.' . $avatar->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/products');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $avatar->move($destinationPath, $fileName);

            // Lưu đường dẫn ảnh mới
            $productData['avatar'] = 'products/' . $fileName;
        }

        // Cập nhật thông tin sản phẩm
        $product->update($productData);

        // Lưu lại transaction
        DB::commit();

        // Redirect về trang chi tiết sản phẩm với thông báo thành công
        return redirect()->route('admin.products.show', $id)->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }


    public function destroy($id)
    {
        DB::beginTransaction();


        // Tìm sản phẩm cần xóa
        $product = Product::findOrFail($id);

        // Xóa avatar của sản phẩm nếu có
        if ($product->avatar && file_exists(storage_path('app/public/' . $product->avatar))) {
            unlink(storage_path('app/public/' . $product->avatar));
        }

        // Lấy các biến thể của sản phẩm
        $variants = $product->variants;

        // Xóa ảnh của các biến thể nếu có
        foreach ($variants as $variant) {
            if ($variant->image && file_exists(storage_path('app/public/' . $variant->image))) {
                unlink(storage_path('app/public/' . $variant->image));
            }
        }

        // Xóa các biến thể của sản phẩm
        ProductVariant::where('product_id', $id)->delete();

        // Xóa sản phẩm
        $product->delete();

        // Lưu lại transaction
        DB::commit();

        // Redirect về trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa thành công.');
    }
}
