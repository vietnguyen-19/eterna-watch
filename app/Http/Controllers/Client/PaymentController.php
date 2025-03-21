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
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'full_name'       => 'required|string|max:255',
            'phone_number'    => 'required|string|max:20',
            'email'           => 'required|email|max:255',
            'street_address'  => 'required|string|max:255',
            'ward'            => 'required|string|max:255',
            'district'        => 'required|string|max:255',
            'city'            => 'required|string|max:255',
            'country'         => 'required|string|max:255',
            'note'            => 'nullable|string|max:1000',

            'cart_items'                 => 'required|array|min:1',
            'cart_items.*.variant_id'    => 'required|integer|exists:product_variants,id',
            'cart_items.*.price'         => 'required|numeric|min:0',
            'cart_items.*.quantity'      => 'required|integer|min:1',

            'voucher_id'      => 'nullable|integer|exists:vouchers,id',
            'total_amount'    => 'required|numeric|min:0',
            'shipping_method' => 'required|string|in:free,store,fixed',
            'payment_method'  => 'required|string|in:cash,vnpay',
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
                'voucher_id'   => $validatedData['voucher_id'] ?? null,
                'total_amount' => $validatedData['total_amount'],
                'status'       => 'pending',
                'order_code'   => 'ORD-' . time() . '-' . Str::upper(Str::random(4)),
            ]);


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
            // Xử lý sản phẩm trong đơn hàng
            foreach ($validatedData['cart_items'] as $item) {
                $variant = ProductVariant::find($item['variant_id']);

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
            }

            // Cập nhật voucher nếu có
            if (!empty($validatedData['voucher_id'])) {
                Voucher::where('id', $validatedData['voucher_id'])->increment('used_count');
            }

            DB::commit();

            // Xử lý thanh toán
            return $validatedData['payment_method'] === 'cash'
                ? $this->payWithCash($order->id)
                : $this->payWithVNPay($order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Lỗi khi đặt hàng: ' . $e->getMessage()
            ], 500);
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

        return redirect()->route('payment.complete', $order->id)
            ->with('message', 'Thanh toán thành công! Giỏ hàng đã được làm trống.');
    }
    public function payWithCash($order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->status = 'pending'; // Chờ nhận tiền
        $order->save();

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'Cash',
            'amount' => $order->total_amount,
            'payment_status' => 'pending',
        ]);
        session()->forget('cart');
        if ($order) {
            $variantIds = OrderItem::where('order_id', $order->id)->pluck('variant_id')->toArray();
            CartDetail::whereIn('variant_id', $variantIds)->delete();
        }
        return redirect()->route('payment.complete', $order->id)->with('message', 'Thanh toán bằng tiền mặt, chờ xác nhận!');
    }
}