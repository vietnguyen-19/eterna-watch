<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
      
        try {
            // Xác thực dữ liệu đầu vào
            $data = $request->validate([
                'total_amount'    => 'required|numeric|min:0',
                'voucher_id'      => 'nullable|integer|exists:vouchers,id',
                'shipping_method' => 'required|in:fixed,free,store',
                'shipping'        => 'required|numeric|min:0',
                'discount_price'  => 'nullable|numeric|min:0',
                'full_name'       => 'required|string|max:255',
                'phone_number'    => 'required',
                'email'           => 'required|email|max:255',
                'street_address'  => 'required|string|max:255',
                'ward'            => 'required|string|max:255',
                'district'        => 'required|string|max:255',
                'city'            => 'required|string|max:255',
                'country'         => 'required|string|max:255',
                'note'            => 'nullable|string|max:1000',
            ]);

            // Lấy giỏ hàng
            if (Auth::check()) {
                // Người dùng đã đăng nhập => Lấy giỏ hàng từ database
                $userId = Auth::id();
                $cart = Cart::where('user_id', $userId)->first();

                if ($cart) {
                    $cartItems = CartDetail::where('cart_id', $cart->id)
                        ->with('productVariant.product', 'productVariant.attributeValues.nameValue.attribute')
                        ->get();
                } else {
                    $cartItems = collect(); // Nếu giỏ hàng rỗng, trả về Collection rỗng
                }
            } else {
                // Người dùng chưa đăng nhập => Lấy giỏ hàng từ session
                $cartItems = session()->get('cart', []);
            }
         
            return view('client.checkout', compact('data', 'cartItems'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
