<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Lấy dữ liệu từ session
        $variantDetails = session('checkout_data.variantDetails', []);
        $voucher        = session('checkout_data.voucher', null);
        $discount       = session('checkout_data.discount', 0);
        $totalAmount    = session('checkout_data.totalAmount', 0);
        $totalFirst     = session('checkout_data.totalFirst', 0);
        $totalItems     = session('checkout_data.totalItems', 0);

        // Trả về view với từng biến riêng lẻ
        return view('client.checkout', compact(
            'variantDetails',
            'voucher',
            'discount',
            'totalAmount',
            'totalFirst',
            'totalItems'
        ));
    }


    public function store(Request $request)
    {
        $orderItems = json_decode($request->input('order_items'), true);
        if (!$orderItems || !is_array($orderItems)) {
            return redirect()->back()->with('error', 'Dữ liệu giỏ hàng không hợp lệ.');
        }

        // Xử lý discount
        $discount = $request->input('discount', 0);
        $discount = (int) str_replace('.', '', $discount); // Loại bỏ dấu chấm, chuyển thành số

        // Lấy voucher_id từ request (có thể null)
        $voucherId = $request->input('voucher_id');

        // Khởi tạo các biến
        $totalFirst = 0;
        $totalItems = 0;

        // Lấy danh sách variant_id từ orderItems
        $variantIds = array_column($orderItems, 'variant_id');

        // Truy vấn thông tin sản phẩm (Eager Loading)
        $variants = ProductVariant::with(['product', 'attributeValues.nameValue.attribute'])
            ->whereIn('id', $variantIds)
            ->get()
            ->keyBy('id'); // Để tìm variant nhanh hơn

        // Mảng để lưu thông tin sản phẩm đã xử lý
        foreach ($orderItems as $item) {
            $variant = $variants->get($item['variant_id']);

            if ($variant) { // Chỉ xử lý nếu tìm thấy sản phẩm
                $quantity = max(1, (int) $item['quantity']); // Đảm bảo số lượng hợp lệ
                $subtotal = $variant->price * $quantity;

                $variantDetails[] = [
                    'variant' => $variant,
                    'quantity' => $quantity,
                    'total' => $subtotal
                ];

                $totalFirst += $subtotal;
                $totalItems += $quantity;
            }
        }

        // Nếu có voucher_id, kiểm tra xem voucher có tồn tại không
        $voucher = $voucherId ? Voucher::find($voucherId) : null;

        // Tính tổng tiền sau khi áp dụng giảm giá
        $totalAmount = max(0, $totalFirst - $discount);

        session([
            'checkout_data' => [
                'variantDetails' => $variantDetails,
                'voucher'        => $voucher,
                'discount'       => $discount,
                'totalAmount'    => $totalAmount,
                'totalFirst'     => $totalFirst,
                'totalItems'     => $totalItems,
            ]
        ]);
        return redirect()->route('checkout.index');
    }
}
