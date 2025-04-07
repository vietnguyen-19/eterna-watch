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
use App\Http\Controllers\Client\PaymentController;

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
        // Validate dữ liệu
        $validatedData = $request->validate([
            'full_name'       => 'required|string|max:255',
            'phone_number'    => 'required|string|max:20',
            'email'           => 'required|email|max:255',
            'street_address'  => 'required|string|max:255',
            'ward'            => 'required|string|max:255',
            'district'        => 'required|string|max:255',
            'city'            => 'required|string|max:255',
            'country'        => 'required|string|max:255',
            'note'           => 'nullable|string|max:1000',
            'total_amount'   => 'required|numeric|min:0',
            'shipping_method' => 'required|string|in:free,store,fixed',
            'payment_method' => 'required|string|in:cash,vnpay',
        ]);

        // Xử lý thanh toán dựa trên phương thức được chọn
        if ($request->payment_method === 'vnpay') {
            return app(PaymentController::class)->vnpay($request);
        } else {
            return app(PaymentController::class)->checkout($request);
        }
    }
}
