<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\StatusHistory;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function complete($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'orderItems.productVariant.attributeValues.nameValue', 'entity', 'payment', 'voucher'])->findOrFail($id);
        return view('client.complete-order', compact('order'));
    }
    public function checkout(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'phone_number'   => 'required',
            'email'          => 'required|email|max:255',
            'street_address' => 'required|string|max:255',
            'ward'           => 'required|string|max:255',
            'district'       => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'country'        => 'required|string|max:255',
            'total_amount'   => 'required|numeric|min:0',
            'voucher_id'     => 'nullable|integer|exists:vouchers,id',
            'note'           => 'nullable|string|max:1000',
            'cart_items'     => 'required|array|min:1',
            'cart_items.*.variant_id' => 'required|integer|exists:product_variants,id',
            'cart_items.*.quantity'   => 'required|integer|min:1',
            'cart_items.*.price'      => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,vnpay,paypal',
        ]);

        DB::beginTransaction(); // Bắt đầu transaction để đảm bảo dữ liệu nhất quán
        try {
            // Kiểm tra user
            $userId = Auth::id(); // Lấy ID của user đã đăng nhập

            if (!$userId) {
                $user = $this->createUser($validated);
                $userId = $user->id;
            }

            // Tạo đơn hàng
            $order = new Order();
            $order->user_id      = $userId;
            $order->voucher_id   = $request->voucher_id;
            $order->total_amount = $request->total_amount;
            $order->status       = 'pending';
            $order->order_code   = 'ORD-' . time() . '-' . Str::upper(Str::random(4));
            $order->save();
            $orderId = $order->id;
            // Xử lý sản phẩm trong đơn hàng
            foreach ($request->cart_items as $item) {
                $variant = ProductVariant::find($item['variant_id']);
                if (!$variant || $variant->stock < $item['quantity']) {
                    throw new \Exception('Sản phẩm không đủ hàng: ' . $variant->id);
                }

                OrderItem::create([
                    'order_id'    => $order->id,
                    'variant_id'  => $variant->id,
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $variant->price,
                    'total_price' => $variant->price * $item['quantity']
                ]);

                $variant->decrement('stock', $item['quantity']);
            }


            // Cập nhật voucher nếu có
            if ($request->voucher_id) {
                Voucher::where('id', $request->voucher_id)->increment('used_count');
            };
            DB::commit(); // Lưu toàn bộ thay đổi vào database

            if ($request->payment_method === 'cash') {
                return $this->payWithCash($orderId);
            } else {
                return $this->payWithVNPay($orderId);
            }
        } catch (\Exception $e) {
            DB::rollBack(); // Nếu có lỗi, hủy toàn bộ thay đổi
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
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone_number'],
            'password' => Hash::make(Str::random(10)), // Tạo mật khẩu ngẫu nhiên
            'role_id'  => 2,  // Mặc định role user
            'status'   => 'active'
        ]);

        UserAddress::create([
            'user_id'        => $user->id,
            'full_name'      => $data['name'],
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

    // Xử lý callback từ VNPay
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


    // Xử lý thanh toán tiền mặt
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
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            CartDetail::where('cart_id', $cart->id)->delete();
            $cart->delete(); // Xóa luôn giỏ hàng nếu cần
        }
        return redirect()->route('payment.complete', $order->id)->with('message', 'Thanh toán bằng tiền mặt, chờ xác nhận!');
    }
}


// <div class="card" id="customerList">
// <div class="card-header border-bottom-dashed">
//     <h5 class="card-title mb-0"><b>Lịch sử trạng thái đơn hàng</b></h5>
// </div>

// <div class="card-body">
//     <div class="list-group">


//         <div class="">
//             <h2>Thanh toán đơn hàng #{{ $order->id }}</h2>
//             <p>Tổng tiền: {{ number_format($order->total_amount, 0, ',', '.') }} VND</p>

//             <!-- Chọn phương thức thanh toán -->
//             <form action="{{ route('payment.cash', $order->id) }}" method="POST">
//                 @csrf
//                 <button type="submit" class="btn btn-primary">Thanh toán bằng tiền
//                     mặt</button>
//             </form>

//             <form action="{{ route('payment.vnpay', $order->id) }}" method="POST">
//                 @csrf
//                 <button type="submit" class="btn btn-success">Thanh toán qua VNPay</button>
//             </form>
//         </div>

//     </div>
// </div>
// </div>
