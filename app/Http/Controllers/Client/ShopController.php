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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Validation cho min_price và max_price
        $validator = Validator::make($request->all(), [
            'min_price' => 'nullable|numeric|min:0|max:1000000000',
            'max_price' => 'nullable|numeric|min:0|max:1000000000',
            'query' => 'nullable|string|max:255', // Validation cho query

        ], [
            'min_price.numeric' => 'Giá tối thiểu phải là số.',
            'min_price.min' => 'Giá tối thiểu không được nhỏ hơn 0 ₫.',
            'min_price.max' => 'Giá tối thiểu không được lớn hơn 1,000,000,000 ₫.',
            'max_price.numeric' => 'Giá tối đa phải là số.',
            'max_price.min' => 'Giá tối đa không được nhỏ hơn 0 ₫.',
            'max_price.max' => 'Giá tối đa không được lớn hơn 1,000,000,000 ₫.',
        ]);

        // Kiểm tra min_price <= max_price
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            if (is_numeric($minPrice) && is_numeric($maxPrice) && $minPrice > $maxPrice) {
                $validator->errors()->add('min_price', 'Giá tối thiểu không được lớn hơn giá tối đa.');
            }
        }

        // Nếu validation thất bại, trả về với lỗi
        if ($validator->fails()) {
            return redirect()->route('client.shop')
                ->withErrors($validator)
                ->withInput($request->all());
        }
        $productsQuery = Product::with(['brand', 'category', 'variants']);

        // Ghi log yêu cầu để kiểm tra
        Log::info('Filter Request:', $request->all());

        // Lọc theo từ khóa tìm kiếm
        if ($request->has('query') && $request->input('type') === 'product') {
            $query = trim($request->input('query'));
            if (!empty($query)) {
                $productsQuery->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('short_description', 'like', "%{$query}%")
                      ->orWhere('full_description', 'like', "%{$query}%");
                });
            }
        }

        // Lọc theo danh mục
        if ($request->has('category_ids') && !empty($request->input('category_ids'))) {
            $categoryIds = $request->input('category_ids', []);
            $allCategoryIds = [];

            foreach ($categoryIds as $categoryId) {
                $category = Category::find($categoryId);
                if ($category) {
                    if ($category->parent_id === null) {
                        // Lấy danh mục con và con cháu
                        $subCategoryIds = Category::where('parent_id', $category->id)
                            ->orWhereHas('parent', function ($query) use ($category) {
                                $query->where('parent_id', $category->id);
                            })
                            ->pluck('id')
                            ->toArray();
                        $allCategoryIds = array_merge($allCategoryIds, [$category->id], $subCategoryIds);
                    } else {
                        $allCategoryIds[] = $category->id;
                    }
                }
            }

            if (!empty($allCategoryIds)) {
                $productsQuery->whereIn('category_id', array_unique($allCategoryIds));
            }
        }

        // Lọc theo thương hiệu
        if ($request->has('brand_ids') && !empty($request->input('brand_ids'))) {
            $brandIds = $request->input('brand_ids', []);
            $allBrandIds = [];

            foreach ($brandIds as $brandId) {
                $allBrandIds[] = $brandId;
                // Lấy thương hiệu con
                $subBrandIds = Brand::where('parent_id', $brandId)->pluck('id')->toArray();
                $allBrandIds = array_merge($allBrandIds, $subBrandIds);
            }

            if (!empty($allBrandIds)) {
                $productsQuery->whereIn('brand_id', array_unique($allBrandIds));
            }
        }

        // Lọc theo giá
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->input('min_price', 0);
            $maxPrice = $request->input('max_price', 1000000000);
            if (is_numeric($minPrice) && is_numeric($maxPrice) && $minPrice <= $maxPrice) {
                $productsQuery->whereBetween('price_default', [$minPrice, $maxPrice]);
            }else {
                Log::warning('Invalid price filter:', ['min_price' => $minPrice, 'max_price' => $maxPrice]);
            }
        }

        // Sắp xếp sản phẩm
        if ($request->has('filter') && !empty($request->input('filter'))) {
            $filter = $request->input('filter');
            switch ($filter) {
                case 'best_selling':
                    $productsQuery->select('products.*')
                        ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                        ->join('order_items', 'product_variants.id', '=', 'order_items.variant_id')
                        ->join('orders', 'order_items.order_id', '=', 'orders.id')
                        ->where('orders.status', 'completed')
                        ->groupBy('products.id')
                        ->orderByRaw('SUM(order_items.quantity) DESC');
                    break;
                case 'az':
                    $productsQuery->orderBy('name', 'asc');
                    break;
                case 'za':
                    $productsQuery->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $productsQuery->orderBy('price_default', 'asc');
                    break;
                case 'price_desc':
                    $productsQuery->orderBy('price_default', 'desc');
                    break;
                case 'date_old':
                    $productsQuery->orderBy('created_at', 'asc');
                    break;
                case 'date_new':
                    $productsQuery->orderBy('created_at', 'desc');
                    break;
                default:
                    $productsQuery->latest('id');
                    break;
            }
        } else {
            $productsQuery->latest('id');
        }

        // Lấy danh sách danh mục và thương hiệu
        $categories = Category::withCount('products')->get();
        $brands = Brand::get();

        // Ghi log truy vấn để kiểm tra
        Log::info('SQL Query:', ['query' => $productsQuery->toSql(), 'bindings' => $productsQuery->getBindings()]);

        // Phân trang sản phẩm
        $products = $productsQuery->paginate(12);

        // Ghi log số lượng sản phẩm
        Log::info('Products Count:', ['count' => $products->total()]);

        return view('client.shop', compact('products', 'categories', 'brands'));
    }

    // Các phương thức khác giữ nguyên
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

        $variants = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'price' => $variant->price,
                'quantity' => $variant->stock,
                'attributes' => $variant->attributeValues->pluck('attribute_value_id')->toArray(),
            ];
        });

        $comments = $this->getCommentsWithReplies($product->id);

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
            'variants' => $variants,
            'comments' => $comments,
            'ratingSummary' => $ratingSummary
        ]);
    }

    public function getCommentsWithReplies($productId, $parentId = null)
    {
        $comments = Comment::where('entity_id', $productId)
            ->where('entity_type', 'product')
            ->where('status', '!=', 'rejected')
            ->where('parent_id', $parentId)
            ->with('replies')
            ->get();

        foreach ($comments as $comment) {
            $comment->replies = $this->getCommentsWithReplies($productId, $comment->id);
        }

        return $comments;
    }

    public function getVariantPrice(Request $request)
    {
        $productId = $request->input('product_id');
        $attributeValues = $request->input('values', []);

        if (!$productId || empty($attributeValues)) {
            return response()->json(['error' => 'Thiếu thông tin sản phẩm hoặc thuộc tính'], 400);
        }

        $productVariant = ProductVariant::where('product_id', $productId)
            ->whereHas('attributes', function ($query) use ($attributeValues) {
                $query->whereIn('idvalueattribute', $attributeValues);
            }, '=', count($attributeValues))
            ->first();

        if (!$productVariant) {
            return response()->json(['error' => 'Không tìm thấy biến thể sản phẩm'], 404);
        }

        return response()->json([
            'variant_id' => number_format($productVariant->price, 0, ',', '.'),
            'price' => $productVariant->price
        ]);
    }
}