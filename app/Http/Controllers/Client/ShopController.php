<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Comment;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $productsQuery = Product::with(['brand', 'category', 'variants']);

        // Lọc theo danh mục cha + con
        if ($request->has('category')) {
            $categoryName = $request->input('category');

            // Lấy ID của danh mục cha và tất cả danh mục con
            $categoryIds = Category::where('name', $categoryName)
                ->orWhereHas('parent', function ($query) use ($categoryName) {
                    $query->where('name', $categoryName);
                })
                ->pluck('id')
                ->toArray();

            $productsQuery->whereIn('category_id', $categoryIds);
        }

        // Lọc theo thương hiệu cha + con
        if ($request->has('brand')) {
            $brandName = $request->input('brand');

            // Lấy ID của thương hiệu cha và tất cả thương hiệu con
            $brandIds = Brand::where('name', $brandName)
                ->orWhereHas('parent', function ($query) use ($brandName) {
                    $query->where('name', $brandName);
                })
                ->pluck('id')
                ->toArray();

            $productsQuery->whereIn('brand_id', $brandIds);
        }

        // Phân trang sản phẩm
        $products = $productsQuery->latest('id')->paginate(12);

        return view('client.shop', compact('products'));
    }
    public function filterProducts(Request $request)
    {

        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 1000000);

        $products = Product::with(['brand', 'category'])

            ->whereBetween('price_default', [$minPrice, $maxPrice])->latest('id')->paginate(12);
        return view('client.shop', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with([
            'brand',
            'category.parent',
            'variants.attributeValues.nameValue',
            'attributes.attributeValues'
        ])->findOrFail($id);

        $attributes = Attribute::select('id', 'attribute_name')->get();

        $parentCategoryId = $product->category->parent_id ?? $product->category_id;

        $productRelated = Product::whereHas('category', function ($query) use ($parentCategoryId) {
            $query->where('id', $parentCategoryId)->orWhere('parent_id', $parentCategoryId);
        })->where('id', '!=', $id)
            ->limit(8)
            ->get();

        // Xử lý dữ liệu biến thể để đảm bảo định dạng đúng
        $variants = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'price' => $variant->price,
                'quantity' => $variant->stock,
                'attributes' => $variant->attributeValues->pluck('attribute_value_id')->toArray(), // Lấy danh sách ID thuộc tính
            ];
        });
        $comments = $this->getCommentsWithReplies($product->id);
       
        return view('client.product', [
            'product' => $product,
            'attributes' => $attributes,
            'productRelated' => $productRelated,
            'variants' => $variants, // Gửi biến thể xuống view
            'comments' => $comments, // Gửi biến thể xuống view
        ]);
    }
    public function getCommentsWithReplies($productId, $parentId = null)
    {
        $comments = Comment::where('entity_id', $productId)
            ->where('entity_type', 'product')
            ->where('parent_id', $parentId)
            ->with('replies') // Để lấy các bình luận con
            ->get();

        foreach ($comments as $comment) {
            // Lấy các bình luận con của mỗi bình luận
            $comment->replies = $this->getCommentsWithReplies($productId, $comment->id);
        }

        return $comments;
    }


    public function getVariantPrice(Request $request)
    {
        // Lấy dữ liệu từ request
        $productId = $request->input('product_id');
        $attributeValues = $request->input('values', []);

        // Kiểm tra dữ liệu đầu vào
        if (!$productId || empty($attributeValues)) {
            return response()->json(['error' => 'Thiếu thông tin sản phẩm hoặc thuộc tính'], 400);
        }

        // Tìm ProductVariant phù hợp
        $productVariant = ProductVariant::where('product_id', $productId)
            ->whereHas('attributes', function ($query) use ($attributeValues) {
                $query->whereIn('idvalueattribute', $attributeValues);
            }, '=', count($attributeValues))
            ->first();

        dd($productVariant);
        // Kiểm tra nếu không tìm thấy
        if (!$productVariant) {
            return response()->json(['error' => 'Không tìm thấy biến thể sản phẩm'], 404);
        }

        // Trả về giá của biến thể sản phẩm
        return response()->json([
            'variant_id' => number_format($productVariant->price, 0, ',', '.'),
            'price' => $productVariant->price
        ]);
    }
}
