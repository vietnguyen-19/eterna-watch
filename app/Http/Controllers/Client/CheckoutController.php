<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

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
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
            'country' => 'required|string|max:255',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:cash,vnpay',
            'shipping_method' => 'required|in:fixed,store'
        ]);

        // Lấy dữ liệu từ session
        $checkoutData = session('checkout_data');
        if (!$checkoutData) {
            return redirect()->route('client.cart.view')->with('error', 'Giỏ hàng trống!');
        }

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => Auth::id(),
            'voucher_id' => $checkoutData['voucher'] ? $checkoutData['voucher']->id : null,
            'total_amount' => $checkoutData['totalAmount'],
            'status' => 'pending',
            'order_code' => 'ORD-' . time() . '-' . Str::random(4),
            'shipping_address' => $request->street_address,
            'shipping_city' => $request->city,
            'shipping_district' => $request->district,
            'shipping_ward' => $request->ward,
            'shipping_country' => $request->country,
            'shipping_phone' => $request->phone_number,
            'shipping_email' => $request->email,
            'shipping_name' => $request->full_name,
            'note' => $request->note
        ]);

        // Tạo chi tiết đơn hàng
        foreach ($checkoutData['variantDetails'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'variant_id' => $item['variant']->id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['variant']->price,
                'total_price' => $item['total']
            ]);

            // Cập nhật số lượng tồn kho
            $item['variant']->decrement('stock', $item['quantity']);
        }

        // Xóa dữ liệu checkout khỏi session
        session()->forget('checkout_data');

        // Xử lý thanh toán
        if ($request->payment_method === 'vnpay') {
            return redirect()->route('client.payment.vnpay', ['orderId' => $order->id]);
        }

        // Nếu thanh toán khi nhận hàng
        return redirect()->route('client.payment.cash', ['orderId' => $order->id]);
    }
}
