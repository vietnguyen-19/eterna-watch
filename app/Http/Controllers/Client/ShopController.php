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
        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');

            // Tìm danh mục hiện tại
            $category = Category::find($categoryId);

            if ($category) {
                if ($category->parent_id === null) { // Nếu là danh mục cha
                    // Lấy toàn bộ ID của danh mục con và con cháu
                    $categoryIds = Category::where('parent_id', $category->id)
                        ->orWhereHas('parent', function ($query) use ($category) {
                            $query->where('parent_id', $category->id);
                        })
                        ->pluck('id')
                        ->toArray();

                    // Thêm danh mục cha vào danh sách ID
                    $categoryIds[] = $category->id;
                } else {
                    // Nếu là danh mục con, chỉ lấy sản phẩm thuộc danh mục đó
                    $categoryIds = [$category->id];
                }

                $productsQuery->whereIn('category_id', $categoryIds);
            }
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
        if ($request->has('filter')) {
            $filter = $request->input('filter');

            switch ($filter) {
                case 'best_selling':
                    $bestSellingProducts = Product::select('products.*')
                        ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                        ->join('order_items', 'product_variants.id', '=', 'order_items.variant_id')
                        ->join('orders', 'order_items.order_id', '=', 'orders.id')
                        ->where('orders.status', 'completed') // Chỉ tính đơn đã hoàn thành
                        ->groupBy('products.id')
                        ->orderByRaw('SUM(order_items.quantity) DESC')
                        ->limit(8)
                        ->get();

                    break;
                case 'az':
                    $productsQuery->orderBy('name', 'asc'); // A-Z
                    break;
                case 'za':
                    $productsQuery->orderBy('name', 'desc'); // Z-A
                    break;
                case 'price_asc':
                    $productsQuery->orderBy('price_default', 'asc'); // Giá thấp đến cao
                    break;
                case 'price_desc':
                    $productsQuery->orderBy('price_default', 'desc'); // Giá cao đến thấp
                    break;
                case 'date_old':
                    $productsQuery->orderBy('created_at', 'asc'); // Cũ đến mới
                    break;
                case 'date_new':
                    $productsQuery->orderBy('created_at', 'desc'); // Mới đến cũ
                    break;
                default:
                    $productsQuery->latest('id'); // Mặc định theo ID mới nhất
                    break;
            }
        } else {
            $productsQuery->latest('id'); // Mặc định nếu không có filter
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
            'attributes.attributeValues',
        ])->findOrFail($id);
        $product->increment('view_count');
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
        // Gọi logic cũ để lấy danh sách bình luận có replies
        $comments = $this->getCommentsWithReplies($product->id);

        // Thống kê đánh giá sao
        $allRatings = \App\Models\Comment::where('entity_id', $product->id)
            ->where('entity_type', 'product')
            ->where('status', '!=', 'rejected')
            ->whereNull('parent_id')
            ->whereNotNull('rating')
            ->pluck('rating');

        $ratingSummary = [
            'total' => $allRatings->count(),
            'average' => $allRatings->avg() ? round($allRatings->avg(), 1) : 0,
            'stars' => [
                5 => $allRatings->filter(fn($r) => $r == 5)->count(),
                4 => $allRatings->filter(fn($r) => $r == 4)->count(),
                3 => $allRatings->filter(fn($r) => $r == 3)->count(),
                2 => $allRatings->filter(fn($r) => $r == 2)->count(),
                1 => $allRatings->filter(fn($r) => $r == 1)->count(),
            ]
        ];

      


        return view('client.product', [
            'product' => $product,
            'attributes' => $attributes,
            'productRelated' => $productRelated,
            'variants' => $variants, // Gửi biến thể xuống view
            'comments' => $comments,
            'ratingSummary'=>$ratingSummary // Gửi biến thể xuống view
        ]);
    }
    public function getCommentsWithReplies($productId, $parentId = null)
    {
        $comments = Comment::where('entity_id', $productId)
            ->where('entity_type', 'product')
            ->where('status', '!=', 'rejected') // Lấy tất cả trạng thái trừ rejected
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
