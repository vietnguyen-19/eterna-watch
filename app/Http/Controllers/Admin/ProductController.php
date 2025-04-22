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
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function uploadAvatar(Request $request)
    {
        return $this->uploadImage($request, 'products');
    }

    /**
     * Xóa ảnh avatar
     */
    public function removeAvatar(Request $request)
    {
        return $this->removeImage($request);
    }

    /**
     * Xử lý upload ảnh
     */
    private function uploadImage(Request $request, $folder)
    {
        // Kiểm tra xem file có được tải lên không
        if (!$request->hasFile('avatar')) {
            return response()->json(['success' => false, 'message' => 'Không có file nào được gửi lên']);
        }

        $file = $request->file('avatar');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Lưu file vào storage/app/public/{folder}
        $path = $file->storeAs("public/$folder", $fileName);

        return response()->json([
            'success' => true,
            'fileName' => asset("storage/$folder/$fileName")
        ]);
    }

    /**
     * Xóa ảnh từ storage
     */
    private function removeImage(Request $request)
    {
        $filePath = $request->input('file'); // Lấy đường dẫn file từ request

        if (!$filePath) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy đường dẫn ảnh']);
        }

        // Chuyển đổi đường dẫn public thành storage path
        $storagePath = str_replace('/storage/', 'public/', $filePath);

        // Kiểm tra file tồn tại không
        if (!Storage::exists($storagePath)) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy ảnh']);
        }

        Storage::delete($storagePath); // Xóa file
        return response()->json(['success' => true, 'message' => 'Ảnh đã được xóa']);
    }
    public function store(ProductStoreRequest $request)
    {

        DB::beginTransaction();

        try {
            // Khởi tạo mảng dữ liệu cho sản phẩm
            $productData = [
                'name' => $request->name,
                'price_default' => $request->price_default,
                'avatar' => $request->avatar,
                'short_description' => $request->short_description,
                'full_description' => $request->full_description,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'status' => $request->status,
            ];


            // Tạo sản phẩm mới trong bảng products
            $product = Product::create($productData);

            // Kiểm tra nếu có attribute_values từ request
            if ($request->has('attribute_values') && is_array($request->attribute_values)) {
                foreach ($request->attribute_values as $attributeName) {
                    ProductHasAttribute::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attributeName
                    ]);
                }
            }

            // Lưu lại transaction
            DB::commit();

            return redirect()->route('admin.productvariants.create', $product->id)->with('success', 'Sản phẩm đã được tạo thành công.');
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
    public function create()
    {

        $categories = Category::select('id', 'name')->whereNull('parent_id')->get();
        $brands = Brand::select('id', 'name')->get();
        $attributes = Attribute::select('id', 'attribute_name')->get();
        $results = AttributeValue::orderBy('attribute_id')->orderBy('id')->get();

        return view('admin.products.create', [
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
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



    public function update(ProductUpdateRequest $request, $id)
    {


        DB::beginTransaction();

        $product = Product::findOrFail($id);
        // Khởi tạo mảng dữ liệu cho sản phẩm
        $productData = [
            'name' => $request->name,
            'avatar' => $request->avatar_hidden ?? $product->avatar,
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
            'avatar' => $productData['avatar'],
            'price_default' => $productData['price_default'],
            'short_description' => $productData['short_description'],
            'full_description' => $productData['full_description'],
            'category_id' => $productData['category_id'],
            'brand_id' => $productData['brand_id'],
            'status' => $productData['status'],
        ];


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
                unlink(storage_path('app/public/' . $product->avatar));
            }

            // Xóa ảnh biến thể
            foreach ($product->variants as $variant) {
                if ($variant->image && file_exists(storage_path('app/public/' . $variant->image))) {
                    unlink(storage_path('app/public/' . $variant->image));
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
