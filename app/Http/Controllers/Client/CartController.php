<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function viewCart()
    {
        // Nếu người dùng đã đăng nhập
        if (Auth::check()) {

            $userId = Auth::id();

            // Kiểm tra nếu user chưa có giỏ hàng thì tạo mới
            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            // Lấy giỏ hàng từ session
            $sessionCart = session()->get('cart', []);

            if (!empty($sessionCart)) {
                // Lấy giỏ hàng từ DB
                $cart = Cart::firstOrCreate(['user_id' => $userId]);

                foreach ($sessionCart as $variantId => $item) {
                    $cartDetail = CartDetail::firstOrNew([
                        'cart_id' => $cart->id,
                        'variant_id' => $variantId
                    ]);

                    // Cộng dồn số lượng nếu sản phẩm đã tồn tại
                    $cartDetail->quantity += $item['quantity'] ?? 0;
                    $cartDetail->price = $item['price'] ?? 0;
                    $cartDetail->save();
                }

                // Xóa giỏ hàng trong session sau khi đã đồng bộ vào database
                session()->forget('cart');
            }
            $userId = Auth::id(); // Lấy ID của user đang đăng nhập
            $cart = Cart::where('user_id', $userId)->first();
            // Lấy giỏ hàng từ database sau khi đồng bộ
            $cart = CartDetail::where('cart_id', $cart->id)
                ->with('productVariant.product', 'productVariant.attributeValues.nameValue.attribute')
                ->get();
        } else {
            // Nếu chưa đăng nhập, lấy giỏ hàng từ session
            $cart = session()->get('cart', []);
        }

        return view('client.cart', compact('cart'));
    }




    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::with('product', 'attributeValues.nameValue.attribute')->findOrFail($request->variant_id);

        if ($request->quantity > $variant->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng đặt hàng vượt quá tồn kho!'
            ]);
        }

        if (Auth::check()) {
            // Người dùng đã đăng nhập, lưu giỏ hàng vào database
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            $cartDetail = CartDetail::firstOrNew([
                'cart_id' => $cart->id,
                'variant_id' => $request->variant_id
            ]);

            // Kiểm tra số lượng mới có vượt quá tồn kho không
            $newQuantity = ($cartDetail->exists ? $cartDetail->quantity : 0) + $request->quantity;
            if ($newQuantity > $variant->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tổng số lượng trong giỏ hàng vượt quá tồn kho!'
                ]);
            }

            // Nếu hợp lệ, cập nhật số lượng sản phẩm trong giỏ hàng
            $cartDetail->quantity = $newQuantity;
            $cartDetail->price = $variant->price;
            $cartDetail->save();
        } else {
            // Người dùng chưa đăng nhập, lưu giỏ hàng vào session
            $cart = session()->get('cart', []);

            $variantId = $request->variant_id;
            $quantity = $request->quantity ?? 1;

            $existingQuantity = isset($cart[$variantId]) ? $cart[$variantId]['quantity'] : 0;
            $newQuantity = $existingQuantity + $quantity;

            if ($newQuantity > $variant->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng đặt trong giỏ hàng vượt quá tồn kho!'
                ]);
            }

            if (isset($cart[$variantId])) {
                $cart[$variantId]['quantity'] = $newQuantity;
            } else {
                $cart[$variantId] = [
                    'variant_id' => $variantId,
                    'name' => $variant->product->name,
                    'price' => $variant->price,
                    'image' => $variant->image ?? 'default.jpg',
                    'quantity' => $quantity,
                    'attributes' => $variant->attributeValues->map(function ($attr) {
                        return [
                            'name' => $attr->nameValue->attribute->attribute_name,
                            'value' => $attr->nameValue->value_name
                        ];
                    })->toArray()
                ];
            }

            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng.',
            'cart' => Auth::check() ? CartDetail::where('cart_id', $cart->id)->count() : count(session('cart', []))
        ]);
    }


    // Xem giỏ hàng


    // Xóa sản phẩm khỏi giỏ hàng
    public function removeItem(Request $request, $variantId)
    {
        if (Auth::check()) {
            $userId = Auth::id(); // Lấy ID của user đang đăng nhập
            $cart = Cart::where('user_id', $userId)->first();
            $cartItem = CartDetail::where('cart_id', $cart->id)
                ->where('variant_id', $variantId)
                ->first();

            if ($cartItem) {
                $cartItem->delete();
                return response()->json(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.']);
            }
        } else {
            // Người dùng chưa đăng nhập, xóa sản phẩm khỏi session
            $cart = Session::get('cart', []);
            if (isset($cart[$variantId])) {
                unset($cart[$variantId]);
                Session::put('cart', $cart);
                return response()->json(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
    }

    // Xóa toàn bộ giỏ hàng
    public function clearCart()
    {
        if (!Auth::check()) {
            // Nếu chưa đăng nhập, xóa toàn bộ giỏ hàng trong session
            Session::forget('cart');
            return response()->json(['success' => true, 'message' => 'Giỏ hàng đã được xóa.']);
        }

        // Nếu đã đăng nhập, chỉ xóa CartItem, giữ lại giỏ hàng
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            CartDetail::where('cart_id', $cart->id)->delete(); // Xóa toàn bộ CartItem
        }

        return response()->json(['success' => true, 'message' => 'Tất cả sản phẩm trong giỏ hàng đã bị xóa.']);
    }
    public function updateCart(Request $request)
    {
        $variantId = $request->variant_id;
        $quantity = max(1, (int) $request->quantity); // Đảm bảo số lượng ít nhất là 1

        if (Auth::check()) {
            // Nếu người dùng đã đăng nhập, cập nhật giỏ hàng trong database
            $cart = Cart::where('user_id', Auth::id())->first();
            $cartItem = CartDetail::where('cart_id', $cart->id)
                ->where('variant_id', $variantId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật số lượng thành công!',
                    'subtotal' => number_format($cartItem->productVariant->price * $quantity, 0, ',', '.')
                ]);
            }
        } else {
            // Nếu chưa đăng nhập, cập nhật giỏ hàng trong session
            $cart = Session::get('cart', []);
            if (isset($cart[$variantId])) {
                $cart[$variantId]['quantity'] = $quantity;
                Session::put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật số lượng thành công!',
                    'subtotal' => number_format($cart[$variantId]['price'] * $quantity, 0, ',', '.')
                ]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
    }

    public function checkVoucher(Request $request)
    {
        $voucherCode = $request->input('code'); // Mã giảm giá từ người dùng
        $orderTotal  = (float) $request->input('total'); // Tổng tiền đơn hàng

        // Tìm voucher theo mã giảm giá
        $voucher = Voucher::where('code', $voucherCode)->first();

        // Kiểm tra voucher có tồn tại không
        if (!$voucher) {
            return response()->json([
                'valid'    => false,
                'message'  => 'Mã giảm giá không tồn tại.',
                'newTotal' => $orderTotal
            ]);
        }

        // Kiểm tra trạng thái voucher (ví dụ: active)
        if ($voucher->status !== 'active') {
            return response()->json([
                'valid'    => false,
                'message'  => 'Voucher không khả dụng.',
                'newTotal' => $orderTotal
            ]);
        }

        // Kiểm tra số lần sử dụng tối đa
        if ($voucher->max_uses > 0 && $voucher->used_count >= $voucher->max_uses) {
            return response()->json([
                'valid'    => false,
                'message'  => 'Voucher đã hết lượt sử dụng.',
                'newTotal' => $orderTotal
            ]);
        }

        // Kiểm tra tổng đơn hàng có đạt mức tối thiểu áp dụng voucher không
        if ($orderTotal < $voucher->min_order) {
            return response()->json([
                'valid'    => false,
                'message'  => 'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng voucher.',
                'newTotal' => $orderTotal
            ]);
        }

        // Kiểm tra thời gian hiệu lực của voucher: bắt đầu và kết thúc
        $now = Carbon::now();
        if ($voucher->start_date && Carbon::parse($voucher->start_date)->gt($now)) {
            return response()->json([
                'valid'    => false,
                'message'  => 'Voucher chưa bắt đầu có hiệu lực.',
                'newTotal' => $orderTotal
            ]);
        }
        if ($voucher->expires_at && Carbon::parse($voucher->expires_at)->lt($now)) {
            return response()->json([
                'valid'    => false,
                'message'  => 'Voucher đã hết hạn.',
                'newTotal' => $orderTotal
            ]);
        }

        // Tính toán giảm giá dựa trên loại voucher
        $discount = 0;
        if ($voucher->discount_type === 'fixed') {
            // Giảm giá cố định theo giá trị voucher
            $discount = $voucher->discount_value;
        } elseif ($voucher->discount_type === 'percent') {
            // Giảm giá theo phần trăm
            $discount = $orderTotal * ($voucher->discount_value / 100);
        }

        // Đảm bảo giảm giá không vượt quá tổng đơn hàng
        if ($discount > $orderTotal) {
            $discount = $orderTotal;
        }

        $newTotal = $orderTotal - $discount;

        return response()->json([
            'voucher_id' => $voucher->id,
            'valid'    => true,
            'message'  => 'Voucher hợp lệ.',
            'discount' => $discount,
            'newTotal' => $newTotal
        ]);
    }
}
