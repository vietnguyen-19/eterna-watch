<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\Shipment;
use App\Models\StatusHistory;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function complete($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'orderItems.productVariant.attributeValues.nameValue', 'entity', 'payment', 'voucher'])->findOrFail($id);
        return view('client.complete-order', compact('order'));
    }
    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            // Lấy dữ liệu checkout từ session
            $checkoutData = session('checkout_data');
            if (!$checkoutData) {
                return redirect()->route('client.cart.view')->with('error', 'Giỏ hàng trống!');
            }

            // Kiểm tra hoặc tạo user
            if (!Auth::check()) {
                $user = $this->createUser($request->all());
                $userId = $user->id;
            } else {
                $userId = Auth::id();
            }

            // Tạo đơn hàng
            $order = Order::create([
                'user_id'      => $userId,
                'voucher_id'   => $checkoutData['voucher'] ? $checkoutData['voucher']->id : null,
                'total_amount' => $checkoutData['totalAmount'],
                'status'       => 'pending',
                'order_code'   => 'ORD-' . time() . '-' . Str::upper(Str::random(4)),
                'shipping_address' => $request->street_address,
                'shipping_city' => $request->city,
                'shipping_district' => $request->district,
                'shipping_ward' => $request->ward,
                'shipping_country' => $request->country,
                'shipping_phone' => $request->phone_number,
                'shipping_email' => $request->email,
                'shipping_name' => $request->full_name,
                'note'          => $request->note
            ]);

            // Tạo thông tin giao hàng
            $shipment = Shipment::create([
                'order_id'        => $order->id,
                'shipping_method' => $request->shipping_method,
                'shipping_cost'   => match ($request->shipping_method) {
                    'fixed' => 100000,
                    'store', 'free' => 0,
                    default => 0,
                },
                'shipped_date'    => now(),
                'delivered_date'  => null,
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($checkoutData['variantDetails'] as $item) {
                $variant = ProductVariant::find($item['variant']->id);

                if (!$variant || $variant->stock < $item['quantity']) {
                    throw new \Exception('Sản phẩm không đủ hàng: ' . ($variant ? $variant->id : 'Không tìm thấy'));
                }

                OrderItem::create([
                    'order_id'    => $order->id,
                    'variant_id'  => $variant->id,
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $variant->price,
                    'total_price' => $variant->price * $item['quantity'],
                ]);

                $variant->decrement('stock', $item['quantity']);
                if ($variant->stock <= 0) {
                    $variant->update(['status' => 'out_of_stock']);
                }
            }

            // Tạo bản ghi thanh toán COD
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'COD',
                'amount' => $order->total_amount,
                'payment_status' => 'pending',
                'transaction_id' => 'COD-' . time() . '-' . Str::upper(Str::random(4)),
            ]);

            // Xóa giỏ hàng và dữ liệu checkout
            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->first();
                if ($cart) {
                    CartDetail::where('cart_id', $cart->id)->delete();
                    $cart->delete();
                }
            }
            session()->forget(['cart', 'checkout_data']);

            DB::commit();

            // Chuyển hướng đến trang hoàn thành đơn hàng
            return redirect()->route('client.payment.complete', ['id' => $order->id])
                ->with('success', 'Đặt hàng thành công! Mã đơn hàng của bạn là ' . $order->order_code);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }

    /**
     * Tạo user mới nếu chưa có
     */
    private function createUser($data)
    {
        $user = User::create([
            'name'     => $data['full_name'],
            'email'    => $data['email'],
            'phone'    => $data['phone_number'],
            'password' => Hash::make(Str::random(10)), // Tạo mật khẩu ngẫu nhiên
            'role_id'  => 3,  // Mặc định role user
            'status'   => 'active'
        ]);

        UserAddress::create([
            'user_id'        => $user->id,
            'full_name'      => $data['full_name'],
            'phone_number'   => $data['phone_number'],
            'email'          => $data['email'],
            'street_address' => $data['street_address'],
            'ward'           => $data['ward'],
            'district'       => $data['district'],
            'city'           => $data['city'],
            'country'        => $data['country'],
            'is_default'     => 1,
            'note'           => $data['note'] ?? null,
        ]);

        return $user;
    }

    public function payWithVNPay($orderId)
    {

        $order = Order::findOrFail($orderId);

        // Thông tin từ VNPay Sandbox
        $vnp_TmnCode = "V55UHDTK";
        $vnp_HashSecret = "BLQMOCDUF9OSQ9K9JWNYJTZE8DVYWH3H";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('payment.vnpay.callback');

        // Dữ liệu gửi đến VNPay
        $vnp_TxnRef = $order->id . '_' . time();
        $vnp_Amount = $order->total_amount * 100;
        $vnp_Locale = 'vn';
        $vnp_OrderInfo = "Thanh toán đơn hàng #$order->id";
        $vnp_OrderType = 'billpayment';
        $vnp_CreateDate = date('YmdHis');

        // Tạo URL thanh toán
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => request()->ip(),
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }
    public function vnPayCallback(Request $request)
    {
        $inputData = $request->all();
        $order_id = explode('_', $inputData['vnp_TxnRef'])[0];

        $order = Order::findOrFail($order_id);

        if ($inputData['vnp_ResponseCode'] == '00') {
            // Cập nhật trạng thái đơn hàng và tạo thanh toán
            $order->save();

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'VNPay',
                'amount' => $order->total_amount,
                'payment_status' => 'completed',
                'transaction_id' => $inputData['vnp_TransactionNo'],
            ]);

            StatusHistory::create([
                'entity_id' => $order->id,
                'entity_type' => 'payment',
                'old_status' => 'pending',
                'new_status' => 'completed',
                'changed_by' => auth()->id() ?? 1, // ID người thay đổi
                'changed_at' => now(),
            ]);
            // Xóa session giỏ hàng
            session()->forget('cart');
            $cart = Cart::where('user_id', Auth::id())->first();

            if ($cart) {
                CartDetail::where('cart_id', $cart->id)->delete();
                $cart->delete(); // Xóa luôn giỏ hàng nếu cần
            }
        } else {
            StatusHistory::create([
                'entity_id' => $order->id,
                'entity_type' => 'payment',
                'old_status' => 'pending',
                'new_status' => 'fail',
                'changed_by' => auth()->id() ?? 1, // ID người thay đổi
                'changed_at' => now(),
            ]);
        }

        StatusHistory::create([
            'entity_id' => $order->id,
            'entity_type' => 'payment',
            'old_status' => 'pending',
            'new_status' => 'completed',
            'changed_by' => auth()->id() ?? 1,
            'changed_at' => now(),
        ]);

        return redirect()
            ->route('account.order')
            ->with('message', "Đơn hàng #{$order->order_code}đã được đặt thành công. Vui lòng theo dõi trạng thái đơn hàng.");
    }
    public function payWithCash($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            // Tạo bản ghi thanh toán
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'COD',
                'amount' => $order->total_amount,
                'payment_status' => 'pending',
                'transaction_id' => 'COD-' . time() . '-' . Str::upper(Str::random(4)),
            ]);

            // Cập nhật trạng thái đơn hàng
            $order->status = 'processing';
            $order->save();

            // Tạo lịch sử trạng thái
            StatusHistory::create([
                'entity_id' => $order->id,
                'entity_type' => 'order',
                'old_status' => 'pending',
                'new_status' => 'processing',
                'changed_by' => auth()->id() ?? 1,
                'changed_at' => now(),
            ]);

            // Xóa giỏ hàng sau khi đặt hàng thành công
            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->first();
                if ($cart) {
                    CartDetail::where('cart_id', $cart->id)->delete();
                    $cart->delete();
                }
            }
            session()->forget('cart');

            // Chuyển hướng đến trang hoàn thành đơn hàng
            return redirect()->route('client.payment.complete', ['id' => $order->id])
                ->with('success', 'Đặt hàng thành công! Mã đơn hàng của bạn là ' . $order->order_code);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function vnpay(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'full_name'       => 'required|string|max:255',
            'phone_number'    => 'required|string|max:20',
            'email'           => 'required|email|max:255',
            'street_address'  => 'required|string|max:255',
            'ward'           => 'required|string|max:255',
            'district'       => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'country'        => 'required|string|max:255',
            'note'           => 'nullable|string|max:1000',
            'total_amount'   => 'required|numeric|min:0',
            'shipping_method' => 'required|string|in:free,store,fixed',
            'payment_method' => 'required|string|in:cash,vnpay',
        ]);

        DB::beginTransaction();
        try {
            // Kiểm tra hoặc tạo user
            if (!Auth::check()) {
                $user = $this->createUser($validatedData);
                $userId = $user->id;
            } else {
                $userId = Auth::id();
            }

            // Tạo đơn hàng
            $order = Order::create([
                'user_id'      => $userId,
                'total_amount' => $validatedData['total_amount'],
                'status'       => 'pending',
                'order_code'   => 'ORD-' . time() . '-' . Str::upper(Str::random(4)),
            ]);

            // Tạo thông tin giao hàng
            $shipment = Shipment::create([
                'order_id'        => $order->id,
                'shipping_method' => $validatedData['shipping_method'],
                'shipping_cost'   => match ($validatedData['shipping_method']) {
                    'fixed' => 100000,
                    'store', 'free' => 0,
                    default => 0,
                },
                'shipped_date'    => now(),
                'delivered_date'  => null,
            ]);

            // Lưu địa chỉ giao hàng
            UserAddress::create([
                'user_id'        => $userId,
                'full_name'      => $validatedData['full_name'],
                'phone_number'   => $validatedData['phone_number'],
                'email'          => $validatedData['email'],
                'street_address' => $validatedData['street_address'],
                'ward'           => $validatedData['ward'],
                'district'       => $validatedData['district'],
                'city'           => $validatedData['city'],
                'country'        => $validatedData['country'],
                'is_default'     => 0,
                'note'           => $validatedData['note'] ?? null,
            ]);

            DB::commit();

            // Chuyển hướng đến trang thanh toán VNPay
            return $this->payWithVNPay($order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi khi xử lý đơn hàng: ' . $e->getMessage());
        }
    }
}
