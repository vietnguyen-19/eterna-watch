<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\Refund;
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;


class PaymentController extends Controller
{
    public function complete($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'orderItems.productVariant.attributeValues.nameValue', 'entity', 'payment', 'voucher'])->findOrFail($id);
        return view('client.complete-order', compact('order'));
    }

    public function checkout(Request $request)
    {

        $validatedData = $request->validate([
            'full_name'       => 'required|string|max:255',
            'phone_number'    => 'required|string|max:20',
            'email'           => 'required|email|max:255',
            'street_address'  => 'required|string|max:255',
            'ward'            => 'required|string|max:255',
            'district'        => 'required|string|max:255',
            'city'            => 'required|string|max:255',
            'country'         => 'nullable|string|max:255',
            'note'            => 'nullable|string|max:1000',
            'cart_items'      => 'required|array|min:1',
            'cart_items.*.variant_id' => 'required|integer|exists:product_variants,id',
            'cart_items.*.price'      => 'required|numeric|min:0',
            'cart_items.*.quantity'   => 'required|integer|min:1',
            'voucher_id'      => 'nullable|integer|exists:vouchers,id',
            'total_amount'    => 'required|numeric|min:0',
            'shipping_method' => 'required|string|in:free,store,fixed',
            'payment_method'  => 'required|string|in:cash,vnpay',
        ]);

        DB::beginTransaction();

        if ($request->input('type_address') == 'new') {
            $address = UserAddress::create([
                'user_id'        => Auth::user()->id,
                'full_name'      => $validatedData['full_name'],
                'phone_number'   => $validatedData['phone_number'],
                'email'          => $validatedData['email'],
                'street_address' => $validatedData['street_address'],
                'ward'           => $validatedData['ward'],
                'district'       => $validatedData['district'],
                'city'           => $validatedData['city'],
                'country'        => 'Việt Nam',
                'is_default'     => 0,
                'note'           => $validatedData['note'] ?? null,
            ]);
        } else {
            $address = Auth::user()->defaultAddress;
        }

        $order = Order::create([
            'user_id'      => Auth::id(),
            'voucher_id'   => $validatedData['voucher_id'] ?? null,
            'address_id'   => $address->id,

            'name' => Auth::user()->name,
            'order_user_id' => Auth::user()->id,
            'full_name' => $address->full_name ?? 'Người nhận không tên',
            'phone_number' => $address->phone_number ?? '0000000000',
            'email' => $address->email ?? 'example@example.com',
            'street_address' => $address->street_address ?? null,
            'ward' => $address->ward ?? 'Phường X',
            'district' => $address->district ?? 'Quận Y',
            'city' => $address->city ?? 'Hà Nội',

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

        foreach ($validatedData['cart_items'] as $item) {
            $variant = ProductVariant::with('product', 'attributeValues')->find($item['variant_id']);

            if (!$variant) {
                throw new \Exception('Không tìm thấy sản phẩm: ' . $item['variant_id']);
            }

            if ($variant->stock < $item['quantity']) {
                throw new \Exception('Sản phẩm không đủ hàng: ' . $variant->id);
            }

            // Tạo OrderItem
            OrderItem::create([
                'order_id'         => $order->id,
                'variant_id'       => $variant->id,
                'product_name'     => $variant->product->name,
                'image'            => $variant->image,
                'value_attributes' => $variant->attributeValues->pluck('attribute_value_id')->toJson(),
                'quantity'         => $item['quantity'],
                'unit_price'       => $variant->price,
                'total_price'      => $variant->price * $item['quantity'],
            ]);

            $userId = $order->user_id;
            // Cập nhật lại các cart_detail liên quan (trừ người vừa đặt hàng)
            CartDetail::where('variant_id', $variant->id)
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', '!=', $userId); // Loại trừ người vừa đặt
                })
                ->chunk(100, function ($cartDetails) use ($variant) {
                    foreach ($cartDetails as $cartDetail) {
                        if ($variant->stock <= 0) {
                            // Nếu hết hàng thì có thể xóa hoặc đánh dấu
                            $cartDetail->delete();
                            // Hoặc: $cartDetail->update(['is_available' => false]);
                        } elseif ($cartDetail->quantity > $variant->stock) {
                            // Cập nhật số lượng phù hợp với tồn kho
                            $cartDetail->update(['quantity' => $variant->stock]);
                        }
                    }
                });
        }


        if (!empty($validatedData['voucher_id'])) {
            Voucher::where('id', $validatedData['voucher_id'])->increment('used_count');
        }

        DB::commit();

        return $validatedData['payment_method'] === 'cash'
            ? $this->payWithCash($order->id)
            : $this->payWithVNPay($order->id);
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
        $vnp_TxnRef = 'ORD_' . $order->id . '_' . time();
        $vnp_Amount = $order->total_amount * 100;
        $vnp_Locale = 'vn';
        $vnp_OrderInfo = "Thanh toán đơn hàng #{$order->id}";
        $vnp_OrderType = 'billpayment';
        $vnp_CreateDate = date('YmdHis');

        // Lưu thông tin thanh toán tạm thời
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'VNPay',
            'amount' => $order->total_amount,
            'payment_status' => 'pending',
            'txn_ref' => $vnp_TxnRef,
            'payment_date' => now(),
        ]);

        Log::info('Tạo yêu cầu thanh toán VNPay (môi trường thử nghiệm)', [
            'order_id' => $order->id,
            'txn_ref' => $vnp_TxnRef,
            'amount' => $vnp_Amount,
        ]);

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
        $vnp_TxnRef = $inputData['vnp_TxnRef'];
        $order_id = explode('_', $vnp_TxnRef)[1]; // Lấy order_id từ vnp_TxnRef
        $order = Order::findOrFail($order_id);

        $transactionNo = $inputData['vnp_TransactionNo'] ?? null;
        $transactionDate = $inputData['vnp_PayDate'] ?? null;
        $userId = auth()->id() ?? 1;

        Log::info('Phản hồi từ VNPay callback (môi trường thử nghiệm)', [
            'order_id' => $order_id,
            'vnp_TxnRef' => $vnp_TxnRef,
            'vnp_TransactionNo' => $transactionNo,
            'vnp_PayDate' => $transactionDate,
            'vnp_ResponseCode' => $inputData['vnp_ResponseCode'] ?? 'N/A',
        ]);

        // Tìm bản ghi thanh toán hiện có
        $payment = Payment::where('order_id', $order->id)->where('txn_ref', $vnp_TxnRef)->first();

        if (!$payment) {
            Log::error('Không tìm thấy bản ghi thanh toán cho VNPay callback', [
                'order_id' => $order_id,
                'vnp_TxnRef' => $vnp_TxnRef,
            ]);
            return redirect()->route('account.order')->with('error', "Lỗi hệ thống: Không tìm thấy thông tin thanh toán cho đơn hàng #{$order->order_code}.");
        }

        if ($inputData['vnp_ResponseCode'] == '00') {
            // Thanh toán thành công
            $order->payment_method = 'vnpay';
            $order->status = 'pending'; // Chờ xử lý đơn hàng
            $order->save();

            // Giảm tồn kho khi thanh toán thành công
            foreach ($order->orderItems as $orderItem) {
                $variant = ProductVariant::find($orderItem->variant_id);
                if ($variant) {
                    $variant->decrement('stock', $orderItem->quantity);
                    if ($variant->product->type == 'simple') {
                        $variant->product->decrement('stock', $orderItem->quantity);
                    }
                    // Nếu hết hàng, cập nhật trạng thái
                    if ($variant->stock <= 0) {
                        $variant->update(['status' => 'out_of_stock']);
                    }
                }
            }

            $payment->update([
                'payment_status' => 'completed',
                'transaction_id' => $vnp_TxnRef, // Lưu vnp_TxnRef làm transaction_id
                'transaction_no' => $transactionNo,
                'transaction_date' => $transactionDate,
            ]);

            StatusHistory::create([
                'entity_id' => $payment->id,
                'entity_type' => 'payment',
                'old_status' => 'pending',
                'new_status' => 'completed',
                'changed_by' => $userId,
                'changed_at' => now(),
            ]);

            StatusHistory::create([
                'entity_id' => $order->id,
                'entity_type' => 'order',
                'old_status' => 'pending',
                'new_status' => 'pending',
                'changed_by' => $order->user->id,
                'changed_at' => now(),
            ]);

            // Xóa giỏ hàng
            session()->forget('cart');
            if ($order) {
                $variantIds = OrderItem::where('order_id', $order->id)->pluck('variant_id')->toArray();
                CartDetail::whereIn('variant_id', $variantIds)
                    ->where('cart_id', Auth::user()->cart->id) // Thêm điều kiện cart_id để chỉ xóa trong giỏ của user hiện tại
                    ->delete();
            }
            Log::info('Thanh toán VNPay thành công (môi trường thử nghiệm)', [
                'order_id' => $order->id,
                'payment_id' => $payment->id,
                'txn_ref' => $vnp_TxnRef,
                'transaction_no' => $transactionNo,
            ]);
            Mail::to($order->user->email)->send(new OrderPlacedMail($order));

            return redirect()
                ->route('account.order')
                ->with('success', "Đơn hàng #{$order->order_code} đã được đặt thành công. Vui lòng theo dõi trạng thái đơn hàng.");
        } else {
            // Thanh toán thất bại
            $order->payment_method = 'vnpay';
            $order->status = 'cancelled';
            $order->save();

            $payment->update([
                'payment_status' => 'failed',
                'transaction_id' => $vnp_TxnRef,
                'transaction_no' => $transactionNo,
                'transaction_date' => $transactionDate,
            ]);

            StatusHistory::create([
                'entity_id' => $payment->id,
                'entity_type' => 'payment',
                'old_status' => 'pending',
                'new_status' => 'failed',
                'changed_by' => $userId,
                'changed_at' => now(),
            ]);

            StatusHistory::create([
                'entity_id' => $order->id,
                'entity_type' => 'order',
                'old_status' => 'pending',
                'new_status' => 'cancelled',
                'changed_by' => $order->user->id,
                'changed_at' => now(),
            ]);

            // Xóa giỏ hàng
            session()->forget('cart');
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                CartDetail::where('cart_id', $cart->id)->delete();
                $cart->delete();
            }

            Log::error('Thanh toán VNPay thất bại (môi trường thử nghiệm)', [
                'order_id' => $order->id,
                'payment_id' => $payment->id,
                'txn_ref' => $vnp_TxnRef,
                'response_code' => $inputData['vnp_ResponseCode'],
                'message' => $inputData['vnp_ResponseMessage'] ?? 'Không có thông báo',
            ]);

            return redirect()
                ->route('account.order')
                ->with('error', "Thanh toán thất bại cho đơn hàng #{$order->order_code}. Đơn hàng đã được hệ thống hủy tự động.");
        }
    }

    public function payWithCash($order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->payment_method = 'cash';
        $order->status = 'pending';
        $order->save();

        // Giảm tồn kho khi thanh toán thành công
        foreach ($order->orderItems as $orderItem) {
            $variant = ProductVariant::find($orderItem->variant_id);
            if ($variant) {
                $variant->decrement('stock', $orderItem->quantity);
                if ($variant->product->type == 'simple') {
                    $variant->product->decrement('stock', $orderItem->quantity);
                }
                // Nếu hết hàng, cập nhật trạng thái
                if ($variant->stock <= 0) {
                    $variant->update(['status' => 'out_of_stock']);
                }
            }
        }

        Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'payment_status' => 'pending',
            'payment_date' => now(),
        ]);

        StatusHistory::create([
            'entity_id' => $order->id,
            'entity_type' => 'order',
            'old_status' => null,
            'new_status' => 'pending',
            'changed_by' => $order->user->id,
            'changed_at' => now(),
        ]);

        session()->forget('cart');
        if ($order) {
            $variantIds = OrderItem::where('order_id', $order->id)->pluck('variant_id')->toArray();
            CartDetail::whereIn('variant_id', $variantIds)
                ->where('cart_id', Auth::user()->cart->id) // Thêm điều kiện cart_id để chỉ xóa trong giỏ của user hiện tại
                ->delete();
        }
        // Gửi email sau khi tạo đơn thành công
        Mail::to($order->user->email)->send(new OrderPlacedMail($order));

        return redirect()
            ->route('account.order')
            ->with('success', "Đơn hàng #{$order->order_code} đã được đặt thành công. Vui lòng theo dõi trạng thái đơn hàng.");
    }
}
