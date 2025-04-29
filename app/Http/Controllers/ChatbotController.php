<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
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
        return view('client.chatbot');
    }

    public function chat(Request $request)
    {
        try {
            $message = $request->input('message');
            Log::info('Received message:', ['message' => $message]);

            if (empty($message)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vui lòng nhập tin nhắn.'
                ]);
            }

            $isProductQuery = $this->isProductQuery($message);
            Log::info('Is product query:', ['result' => $isProductQuery]);

            if ($isProductQuery) {
                $products = $this->getProductsFromAIAnalysis($message);

                if ($products->isEmpty()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Không tìm thấy sản phẩm phù hợp.'
                    ]);
                }

                $productData = $this->formatProductData($products);

                return response()->json([
                    'status' => 'success',
                    'message' => $productData,
                    'is_html' => true
                ]);
            }

            $response = $this->handleGeneralQuestions($message);
            return response()->json([
                'status' => 'success',
                'message' => $response
            ]);

        } catch (\Exception $e) {
            Log::error('Error in chat:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'
            ]);
        }
    }

    private function isProductQuery($message)
    {
        $message = mb_strtolower($message, 'UTF-8');
        $productKeywords = [
            'đồng hồ', 'watch', 'watches', 'casio', 'seiko', 'citizen', 'tissot', 'fossil',
            'nam', 'nữ', 'men', 'women', 'male', 'female',
            'giá', 'price', 'cost', 'dưới', 'trên', 'khoảng', 'tầm',
            'thể thao', 'sport', 'dạ hội', 'formal', 'công sở', 'elegant',
            'mua', 'bán', 'tư vấn', 'giới thiệu', 'tìm', 'kiếm', 'cần', 'muốn',
            'buy', 'sell', 'recommend', 'suggest', 'find', 'search', 'need', 'want',
            'mẫu', 'model', 'kiểu', 'style', 'loại', 'type', 'dòng', 'line',
            'mới', 'new', 'hot', 'bestseller', 'phổ biến', 'popular', 'trending'
        ];

        $count = 0;
        foreach ($productKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                $count++;
            }
        }

        return $count >= 2; // Nếu có ít nhất 2 từ khóa sản phẩm
    }

    private function getProductsFromAIAnalysis($message)
    {
        $message = mb_strtolower($message, 'UTF-8');
        $query = Product::query()
            ->with(['brand', 'category', 'variants'])
            ->where('status', 'active')
            ->whereHas('variants', function ($q) {
                $q->where('stock', '>', 0);
            });

        // Phân tích thương hiệu
        $this->filterByBrand($message, $query);

        // Phân tích danh mục
        $this->filterByCategory($message, $query);

        // Phân tích giá
        $this->filterByPrice($message, $query);

        // Sắp xếp và lấy sản phẩm
        return $query->orderByRaw('(
            select price from product_variants
            where product_variants.product_id = products.id
            order by price asc
            limit 1
        ) asc')->get();
    }

    private function filterByBrand($message, &$query)
    {
        $brands = Brand::all();
        foreach ($brands as $brand) {
            $brandName = mb_strtolower($brand->name, 'UTF-8');
            if (str_contains($message, $brandName)) {
                $query->where('brand_id', $brand->id);
                break;
            }
        }
    }

    private function filterByCategory($message, &$query)
    {
        $categoryFilters = [
            'thể thao' => ['thể thao', 'sport'],
            'cao cấp' => ['cao cấp', 'luxury'],
            'thời trang' => ['thời trang', 'fashion'],
        ];

        foreach ($categoryFilters as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    $query->whereHas('category', function ($q) use ($type) {
                        $q->where('name', 'like', "%$type%");
                    });
                    break 2;
                }
            }
        }
    }

    private function filterByPrice($message, &$query)
    {
        if (preg_match('/(\d+)\s*(triệu|tr)/i', $message, $matches)) {
            $price = $matches[1] * 1000000;
            $minPrice = $price * 0.8;
            $maxPrice = $price * 1.2;

            $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [$minPrice, $maxPrice]);
            });
        }
    }

    private function formatProductData($products)
    {
        if ($products->isEmpty()) {
            return "Xin lỗi, hiện tại chúng tôi không có sản phẩm phù hợp với yêu cầu của bạn.";
        }

        $formattedData = "Tôi tìm thấy một số sản phẩm:\n\n";
        foreach ($products as $index => $product) {
            $formattedData .= "Sản phẩm " . ($index + 1) . ":\n";
            $formattedData .= "Tên: {$product->name}\n";
            $formattedData .= "Thương hiệu: " . ($product->brand ? $product->brand->name : 'Không xác định') . "\n";
            $formattedData .= "Danh mục: " . ($product->category ? $product->category->name : 'Không xác định') . "\n";

            if ($product->variants->isNotEmpty()) {
                $formattedData .= "Giá: " . number_format($product->variants->first()->price, 0, ',', '.') . " VNĐ\n";
                $formattedData .= "Tình trạng: " . ($product->variants->first()->stock > 0 ? 'Còn hàng' : 'Hết hàng') . "\n";
            }

            $productUrl = route('client.shop.show', $product->id);
            $formattedData .= "🔗 <a href='{$productUrl}'>Xem chi tiết sản phẩm</a>\n";
            $formattedData .= "\n========================================\n\n";
        }

        return $formattedData;
    }

    private function handleGeneralQuestions($message)
    {
        $message = mb_strtolower($message, 'UTF-8');

        if (mb_strpos($message, 'chào') !== false) {
            return "Xin chào! Tôi có thể giúp gì cho bạn?";
        }

        if (mb_strpos($message, 'đặt hàng') !== false) {
            return "Để đặt hàng, bạn có thể:\n1. Thêm sản phẩm vào giỏ hàng\n2. Điền thông tin giao hàng\n3. Chọn phương thức thanh toán\n4. Xác nhận đơn hàng";
        }

        if (mb_strpos($message, 'vận chuyển') !== false) {
            return "Chúng tôi giao hàng toàn quốc với phí vận chuyển từ 100.000 VNĐ. Thời gian giao hàng dự kiến 2-4 ngày làm việc.";
        }

        if (mb_strpos($message, 'thanh toán') !== false) {
            return "Chúng tôi chấp nhận các hình thức thanh toán:\n1. Thanh toán khi nhận hàng (COD)\n2. Chuyển khoản ngân hàng\n3. Thanh toán qua VNPay";
        }

        return "Tôi có thể giúp gì cho bạn? Bạn có thể hỏi về sản phẩm, đặt hàng, vận chuyển hoặc thanh toán.";
    }
}
