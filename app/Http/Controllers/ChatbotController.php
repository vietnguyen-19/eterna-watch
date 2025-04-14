<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Brand;
use App\Models\Category;

class ChatbotController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function index()
    {
        return view('client.contact_us');
    }

    public function chat(Request $request)
    {
        try {
            $message = $request->input('message');
            Log::info('Received chat message:', ['message' => $message]);

            if (empty($message)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vui lòng nhập tin nhắn'
                ]);
            }

            // Check if this is a product query
            $isProductQuery = $this->isProductQuery($message);
            Log::info('Is product query:', ['result' => $isProductQuery]);

            if ($isProductQuery) {
                Log::info('Processing product query');
                try {
                    $products = $this->getRelevantProducts($message);
                    Log::info('Products found:', ['count' => $products->count()]);

                    if ($products->isEmpty()) {
                        Log::info('No products found matching the criteria');
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Xin lỗi, tôi không tìm thấy sản phẩm phù hợp với yêu cầu của bạn. Bạn có thể thử lại với các tiêu chí khác không?'
                        ]);
                    }

                    $productData = $this->formatProductData($products);
                    Log::info('Formatted product data:', ['data' => $productData]);

                    // Trả về dữ liệu sản phẩm với HTML được render
                    return response()->json([
                        'status' => 'success',
                        'message' => $productData,
                        'is_html' => true // Thêm flag để frontend biết cần render HTML
                    ]);

                } catch (\Exception $e) {
                    Log::error('Error processing product query:', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Xin lỗi, có lỗi xảy ra khi tìm kiếm sản phẩm. Vui lòng thử lại sau.'
                    ]);
                }
            }

            // Handle general questions
            try {
                $response = $this->handleGeneralQuestions($message);
                Log::info('Handled general question:', ['response' => $response]);
                
                return response()->json([
                    'status' => 'success',
                    'message' => $response
                ]);
            } catch (\Exception $e) {
                Log::error('Error handling general question:', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Xin lỗi, có lỗi xảy ra khi xử lý câu hỏi. Vui lòng thử lại sau.'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error in chat:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Xin lỗi, đã có lỗi xảy ra. Vui lòng thử lại sau.'
            ]);
        }
    }

    private function isProductQuery($message)
    {
        try {
            $message = mb_strtolower($message, 'UTF-8');
            
            // Danh sách từ khóa liên quan đến sản phẩm
            $productKeywords = [
                'đồng hồ', 'watch', 'watches', 'casio', 'seiko', 'citizen', 'tissot', 'fossil',
                'nam', 'nữ', 'nam giới', 'nữ giới', 'men', 'women', 'male', 'female',
                'giá', 'price', 'cost', 'dưới', 'trên', 'khoảng', 'tầm', 'under', 'above', 'around',
                'thể thao', 'sport', 'dạ hội', 'formal', 'công sở', 'office', 'lịch sự', 'elegant',
                'mua', 'bán', 'tư vấn', 'giới thiệu', 'tìm', 'kiếm', 'cần', 'muốn',
                'buy', 'sell', 'recommend', 'suggest', 'find', 'search', 'need', 'want',
                'mẫu', 'model', 'kiểu', 'style', 'loại', 'type', 'dòng', 'line',
                'mới', 'new', 'hot', 'bestseller', 'phổ biến', 'popular', 'trending'
            ];
            
            // Danh sách từ khóa chung
            $generalKeywords = [
                'xin chào', 'hello', 'hi', 'chào', 'cảm ơn', 'thanks', 'thank you',
                'tạm biệt', 'goodbye', 'bye', 'hẹn gặp lại', 'see you',
                'giúp', 'help', 'hỗ trợ', 'support', 'tôi', 'i', 'bạn', 'you'
            ];
            
            // Đếm số từ khóa sản phẩm và từ khóa chung trong tin nhắn
            $productCount = 0;
            $generalCount = 0;
            
            foreach ($productKeywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    $productCount++;
                }
            }
            
            foreach ($generalKeywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    $generalCount++;
                }
            }
            
            // Log kết quả phân tích
            Log::info('Phân tích tin nhắn:', [
                'message' => $message,
                'product_keywords_found' => $productCount,
                'general_keywords_found' => $generalCount
            ]);
            
            // Nếu có ít nhất 2 từ khóa sản phẩm hoặc 1 từ khóa sản phẩm và không có từ khóa chung
            return $productCount >= 2 || ($productCount >= 1 && $generalCount === 0);
            
        } catch (\Exception $e) {
            Log::error('Lỗi khi phân tích tin nhắn: ' . $e->getMessage());
            return false;
        }
    }

    private function getRelevantProducts($message)
    {
        $query = Product::query()
            ->with(['brand', 'category', 'variants'])
            ->where('status', 'active')
            ->whereHas('variants', function ($q) {
                $q->where('stock', '>', 0);
            });

        // Log tin nhắn gốc
        Log::info('Processing message:', ['message' => $message]);
        
        $message = mb_strtolower($message, 'UTF-8');

        // Lấy tất cả thương hiệu từ database và log
        $allBrands = Brand::all();
        Log::info('All available brands:', ['brands' => $allBrands->pluck('name')->toArray()]);

        // Tìm kiếm thương hiệu trong tin nhắn
        $foundBrandId = null;
        foreach ($allBrands as $brand) {
            $brandName = mb_strtolower($brand->name, 'UTF-8');
            // Kiểm tra cả tên đầy đủ và tên viết tắt của thương hiệu
            if (str_contains($message, $brandName) || 
                str_contains($message, str_replace(' ', '', $brandName)) ||
                str_contains($message, str_replace('-', '', $brandName))) {
                
                $foundBrandId = $brand->id;
                Log::info('Found brand in message:', [
                    'message' => $message,
                    'brand_name' => $brand->name,
                    'brand_id' => $brand->id
                ]);
                break;
            }
        }

        // Nếu tìm thấy thương hiệu, thêm vào query
        if ($foundBrandId) {
            $query->where('brand_id', $foundBrandId);
            
            // Log số lượng sản phẩm của thương hiệu
            $brandProductCount = Product::where('brand_id', $foundBrandId)->count();
            Log::info('Products count for brand:', [
                'brand_id' => $foundBrandId,
                'product_count' => $brandProductCount
            ]);
        } else {
            Log::info('No brand found in message');
        }

        // Lọc theo các danh mục đặc biệt
        $categoryFilters = [
            'thể thao' => ['thể thao', 'sport'],
            'đôi' => ['đôi', 'cặp', 'couple'],
            'cao cấp' => ['cao cấp', 'luxury'],
            'thời trang' => ['thời trang', 'fashion']
        ];

        foreach ($categoryFilters as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    Log::info("Filtering by category: {$type}", ['keyword' => $keyword]);
                    $query->whereHas('category', function ($q) use ($type) {
                        $q->where('name', 'like', '%' . $type . '%');
                    });
                    break 2;
                }
            }
        }

        // Lọc theo giới tính trong danh mục
        if (str_contains($message, 'nam')) {
            Log::info('Filtering by category: nam');
            $query->whereHas('category', function ($q) {
                $q->where('name', 'like', '%nam%')
                  ->orWhere('name', 'like', '%men%');
            });
        } elseif (str_contains($message, 'nữ')) {
            Log::info('Filtering by category: nữ');
            $query->whereHas('category', function ($q) {
                $q->where('name', 'like', '%nữ%')
                  ->orWhere('name', 'like', '%women%');
            });
        }

        // Lọc theo giá
        if (preg_match('/(\d+)\s*(triệu|tr)/i', $message, $matches)) {
            $amount = $matches[1];
            $price = $amount * 1000000;
            
            $minPrice = $price * 0.8;
            $maxPrice = $price * 1.2;
            
            Log::info('Price filtering details:', [
                'original_message' => $message,
                'amount' => $amount,
                'converted_price' => $price,
                'min_price' => $minPrice,
                'max_price' => $maxPrice
            ]);
            
            $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [$minPrice, $maxPrice]);
            });
        }

        // Log SQL query trước khi thực thi
        $sqlQuery = $query->toSql();
        $bindings = $query->getBindings();
        Log::info('Final SQL Query:', [
            'query' => $sqlQuery,
            'bindings' => $bindings
        ]);

        // Sắp xếp theo giá tăng dần
        $query->orderBy(
            ProductVariant::select('price')
                ->whereColumn('product_variants.product_id', 'products.id')
                ->orderBy('price', 'asc')
                ->limit(1),
            'asc'
        );

        // Lấy sản phẩm và log chi tiết
        $products = $query->get();
        
        // Log danh mục của các sản phẩm tìm thấy
        Log::info('Found products categories:', [
            'categories' => $products->pluck('category.name')->unique()->toArray()
        ]);
        
        Log::info('Query results:', [
            'total_products' => $products->count(),
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand ? $product->brand->name : 'N/A',
                    'category' => $product->category ? $product->category->name : 'N/A',
                    'variants_count' => $product->variants->count(),
                    'variants' => $product->variants->map(function ($variant) {
                        return [
                            'id' => $variant->id,
                            'price' => $variant->price,
                            'stock' => $variant->stock
                        ];
                    })->toArray()
                ];
            })->toArray()
        ]);

        return $products;
    }

    private function formatProductData($products)
    {
        if ($products->isEmpty()) {
            return "Xin lỗi, hiện tại chúng tôi không có sản phẩm phù hợp với yêu cầu của bạn. Bạn có thể thử tìm kiếm với các tiêu chí khác hoặc liên hệ với chúng tôi để được tư vấn thêm.";
        }

        $formattedData = "Tôi tìm thấy một số sản phẩm phù hợp với yêu cầu của bạn:\n\n";
        
        foreach ($products as $index => $product) {
            try {
                $formattedData .= "Sản phẩm " . ($index + 1) . ":\n";
                $formattedData .= "----------------------------------------\n";
                $formattedData .= "Tên: {$product->name}\n";
                $formattedData .= "Thương hiệu: " . ($product->brand ? $product->brand->name : 'Không xác định') . "\n";
                $formattedData .= "Danh mục: " . ($product->category ? $product->category->name : 'Không xác định') . "\n";
                
                // Thông tin biến thể và giá
                if ($product->variants && $product->variants->isNotEmpty()) {
                    $formattedData .= "Giá: " . number_format($product->variants->first()->price, 0, ',', '.') . " VNĐ\n";
                    $formattedData .= "Tình trạng: " . ($product->variants->first()->stock > 0 ? 'Còn hàng' : 'Hết hàng') . "\n";
                }
                
                // Thêm đường dẫn sản phẩm với HTML link
                $productUrl = route('client.shop.show', $product->id);
                $formattedData .= "🔗 <a href='{$productUrl}' style='color: #007bff; text-decoration: underline;'>Xem chi tiết sản phẩm</a>\n";
                
                $formattedData .= "\n========================================\n\n";
                
            } catch (\Exception $e) {
                Log::error('Error formatting product data:', [
                    'product_id' => $product->id ?? 'unknown',
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                continue;
            }
        }
        
        $formattedData .= "Bạn có thể xem chi tiết sản phẩm bằng cách nhấp vào link tương ứng. Bạn cần tôi tư vấn thêm về sản phẩm nào không?";
        
        return $formattedData;
    }

    private function handleGeneralQuestions($message)
    {
        $message = mb_strtolower($message, 'UTF-8');
        
        if (mb_strpos($message, 'chào') !== false || mb_strpos($message, 'xin chào') !== false) {
            return "Xin chào! Tôi có thể giúp gì cho bạn?";
        }
        
        if (mb_strpos($message, 'đặt hàng') !== false || mb_strpos($message, 'mua hàng') !== false) {
            return "Để đặt hàng, bạn có thể:\n1. Thêm sản phẩm vào giỏ hàng\n2. Điền thông tin giao hàng\n3. Chọn phương thức thanh toán\n4. Xác nhận đơn hàng";
        }
        
        if (mb_strpos($message, 'vận chuyển') !== false || mb_strpos($message, 'ship') !== false) {
            return "Chúng tôi giao hàng toàn quốc với phí vận chuyển từ 20.000 - 50.000 VNĐ tùy khu vực. Thời gian giao hàng dự kiến 2-5 ngày làm việc.";
        }
        
        if (mb_strpos($message, 'thanh toán') !== false) {
            return "Chúng tôi chấp nhận các hình thức thanh toán:\n1. Thanh toán khi nhận hàng (COD)\n2. Chuyển khoản ngân hàng\n3. Thanh toán qua VNPay";
        }
        
        return "Tôi có thể giúp gì cho bạn? Bạn có thể hỏi về sản phẩm, đặt hàng, vận chuyển hoặc thanh toán.";
    }
} 