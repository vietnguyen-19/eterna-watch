<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHandler;
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
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_default' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0|lt:price_default',
            'type' => 'required|in:simple,variant',
            'avatar' => 'required|file|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'short_description' => 'required|string',
            'full_description' => 'nullable|string',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required',
            'attribute_values' => 'required_if:type,variant|array|nullable',
        ]);

        DB::beginTransaction();

        try {
            // Xử lý ảnh
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = ImageHandler::saveImage($request->file('avatar'), 'products');
            }

            // Chuẩn bị dữ liệu cơ bản
            $productData = [
                'name' => $request->name,
                'price_default' => $request->price_default,
                'price_sale' => $request->price_sale ?? null,
                'type' => $request->type,
                'short_description' => $request->short_description,
                'full_description' => $request->full_description,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'status' => $request->status,
                'avatar' => $avatarPath,
            ];

            if ($request->type === 'simple') {
                Product::create($productData);
                DB::commit();
                return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo thành công.');
            }

            if ($request->type === 'variant') {
                $category = Category::find($request->category_id);
                $brand = $request->brand_id ? Brand::find($request->brand_id) : null;

                $productData['category_name'] = $category ? $category->name : '';
                $productData['brand_name'] = $brand ? $brand->name : '';

                session(['product' => $productData]);

                if ($request->has('attribute_values') && is_array($request->attribute_values)) {
                    $attributes = collect();
                    foreach ($request->attribute_values as $attribute_id) {
                        $attribute = Attribute::with('attributeValues')->find($attribute_id);
                        if ($attribute) {
                            $attributes->push($attribute);
                        }
                    }
                    session(['attributes' => $attributes]);
                }

                DB::commit();
                return redirect()->route('admin.productvariants.create')->with('success', 'Thông tin sản phẩm đã được lưu để tạo biến thể.');
            }

            DB::rollback();
            return back()->with('error', 'Loại sản phẩm không hợp lệ.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }




    public function index()
    {
        $data = Product::with('brand', 'category')->latest('id')->get();
        return view('admin.products.index', [
            'data' => $data,
        ]);
    }
    public function create(Request $request)
    {
        $type = $request->query('type', 'simple');
        $categories = Category::select('id', 'name')->whereNull('parent_id')->get();
        $brands = Brand::select('id', 'name')->get();
        $attributes = Attribute::select('id', 'attribute_name')->get();
        $results = AttributeValue::orderBy('attribute_id')->orderBy('id')->get();

        return view('admin.products.create', [
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
            'type' => $type,
        ]);
    }
    public function getSubcategories($parent_id)
    {
        $subcategories = Category::where('parent_id', $parent_id)->get();
        return response()->json($subcategories);
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

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
       
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_default' => 'required|decimal:0,2|min:0',
            'price_sale' => 'nullable|decimal:0,2|min:0|lt:price_default',
            'avatar' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'short_description' => 'required|string',
            'full_description' => 'nullable|string',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required',
            'attribute_values' => 'nullable|array',
        ]);
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);

            // Xử lý avatar nếu có upload mới
            if ($request->hasFile('avatar')) {
                $avatarPath = imageHandler::updateImage($request->file('avatar'), $product->avatar, 'products');
            } else {
                $avatarPath = $request->avatar_hidden ?? $product->avatar;
            }

            // Cập nhật dữ liệu sản phẩm
            $product->update([
                'name' => $request->name,
                'avatar' => $avatarPath,
                'price_default' => $request->price_default,
                'price_sale' => $request->price_sale,
                'type' => $product->type, // giữ nguyên type cũ
                'short_description' => $request->short_description,
                'full_description' => $request->full_description,
                'category_id' => $request->subcategory_id,
                'brand_id' => $request->brand_id,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.products.show', $id)
                ->with('success', 'Sản phẩm đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật sản phẩm: ' . $e->getMessage());
        }
    }



    public function destroy($id)
    {
        DB::beginTransaction();


        $product = Product::findOrFail($id);

        // Chỉ xóa mềm (không xóa file hay biến thể)
        $product->delete();

        DB::commit();
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được đưa vào thùng rác.');
    }
    public function trash()
    {
        $products = Product::onlyTrashed()->with('variants')->get();

        return view('admin.products.trash', compact('products'));
    }
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.trash')->with('success', 'Sản phẩm đã được khôi phục.');
    }
    public function forceDelete($id)
    {
        DB::beginTransaction();

        try {
            $product = Product::onlyTrashed()->findOrFail($id);

            // Xóa ảnh avatar nếu có
            if ($product->avatar && file_exists(storage_path('app/public/' . $product->avatar))) {
                ImageHandler::deleteImage($product->avatar);
               
            }

            // Xóa ảnh biến thể
            foreach ($product->variants as $variant) {
                if ($variant->image && file_exists(storage_path('app/public/' . $variant->image))) {
                    ImageHandler::deleteImage($variant->image);
                }

                // Xóa mềm hoặc vĩnh viễn tùy theo bạn muốn
                $variant->forceDelete();
            }

            // Xóa luôn bản ghi sản phẩm
            $product->forceDelete();

            DB::commit();

            return redirect()->route('admin.productvariants.trash')->with('success', 'Sản phẩm đã được xóa vĩnh viễn.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
