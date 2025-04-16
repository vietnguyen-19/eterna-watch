<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('address')
            ->where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->limit(10)
            ->get();

        $filteredUsers = $users->map(function ($user) {
            return [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'phone'  => $user->phone,
                'address' => $user->address ? [
                    'city'              => $user->address->city ?? '',
                    'district'          => $user->address->district ?? '',
                    'ward'              => $user->address->ward ?? '',
                    'specific_address'  => $user->address->specific_address ?? '',
                ] : null, // Nếu không có address thì trả về null
            ];
        });

        return response()->json($filteredUsers);
    }


    public function searchPro(Request $request)
    {
        $search = trim($request->input('search'));

        $products = ProductVariant::with('product:id,name')
            ->when($search, function ($query) use ($search) {
                $query->where('sku', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->limit(20)
            ->get(['id', 'product_id', 'sku', 'price', 'image'])
            ->map(function ($variant) {
                return [
                    'id'    => $variant->id,
                    'text'  => $variant->product->name . " - " . $variant->sku, // Text hiển thị trong select2
                    'price' => (float) $variant->price, // Giá của sản phẩm
                    'image' => asset('storage/' . $variant->image), // Đường dẫn hình ảnh sản phẩm
                ];
            });

        // Đảm bảo return đúng định dạng dữ liệu cho Select2
        return response()->json([
            'results' => $products
        ]);
    }


    // Thêm sản phẩm vào OrderItem
    public function addOrderItem(Request $request)
    {
        $orderItem = OrderItem::create([
            'order_id'   => $request->input('order_id'),
            'variant_id' => $request->input('variant_id'),
            'quantity'   => 1, // Mặc định là 1
            'unit_price' => $request->input('price'),
            'total_price' => $request->input('price')
        ]);

        return response()->json($orderItem);
    }

    // Cập nhật số lượng OrderItem
    public function updateOrderItem(Request $request)
    {
        $orderItem = OrderItem::find($request->input('id'));
        if ($orderItem) {
            $orderItem->quantity = $request->input('quantity');
            $orderItem->total_price = $orderItem->unit_price * $orderItem->quantity;
            $orderItem->save();
        }
        return response()->json($orderItem);
    }

    // Xóa OrderItem
    public function removeOrderItem(Request $request)
    {
        OrderItem::where('id', $request->input('id'))->delete();
        return response()->json(['success' => true]);
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
            'voucher_id'=> $voucher->id,
            'valid'    => true,
            'message'  => 'Voucher hợp lệ.',
            'discount' => $discount,
            'newTotal' => $newTotal
        ]);
    }
}
