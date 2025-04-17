<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\StatusHistory;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stringable;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        // Đếm số lượng đơn hàng theo trạng thái
        $statusCounts = Order::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Đảm bảo tất cả trạng thái đều có giá trị
        $allStatuses = ['pending', 'confirmed', 'processing', 'completed', 'cancelled'];
        foreach ($allStatuses as $s) {
            $statusCounts[$s] = $statusCounts[$s] ?? 0;
        }

        // Đếm tổng số đơn hàng
        $statusCounts['all'] = array_sum($statusCounts);

        // Lấy danh sách đơn hàng theo trạng thái
        $orders = Order::with('orderItems')
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders', 'statusCounts', 'status'));
    }
    public function create()
    {
        $productVariants = ProductVariant::all(); // Lấy danh sách biến thể sản phẩm

        return view('admin.orders.create', compact('productVariants'));
    }
    
    public function edit($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'address', 'entity', 'payment', 'voucher'])->findOrFail($id);
       
        $statusHistories = StatusHistory::where('entity_id', $order->id)
            ->where('entity_type', 'order')
            ->orderBy('changed_at', 'desc')  // Sắp xếp theo thời gian thay đổi
            ->get();
        return view('admin.orders.edit', compact('order', 'statusHistories'));
    }
    public function store(Request $request)
    {
       
        DB::beginTransaction();

        // Kiểm tra nếu user_id = null, thì tạo user mới
        if ($request->user_id == null) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => Hash::make(Str::random(10)), // Mật khẩu ngẫu nhiên
                'gender'   => null,
                'avatar'   => null,
                'note'     => null,
                'role_id'  => 2,  // Mặc định role user
                'status'   => 'active'
            ]);

            // Tạo địa chỉ cho user
            UserAddress::create([
                'user_id'          => $user->id,
                'city'             => $request->city,
                'district'         => $request->district,
                'ward'             => $request->ward,
                'specific_address' => $request->specific_address
            ]);

            // Gán user_id mới vào đơn hàng
            $userId = $user->id;
        } else {
            $userId = $request->user_id;
        }

        // Tạo đơn hàng
        $order = new Order();
        $order->user_id      = $userId;
        $order->voucher_id   = $request->voucher_id;
        $order->total_amount = $request->total_amount;
        $order->status       = 'pending';
        $order->order_code = 'ORD-' . $order->id . '-' . Str::random(5);
        $order->save();

        // Xử lý danh sách sản phẩm trong đơn hàng
        foreach ($request->order_items as $item) {
            $variant = ProductVariant::find($item['id']);
            if (!$variant || $variant->stock < $item['quantity']) {
                return redirect()->back()->with('error', 'Sản phẩm không đủ hàng');
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

        if ($request->voucher_id) {
            Voucher::where('id', $request->voucher_id)->increment('used_count');
        }
        Payment::create([
            'order_id'        => $order->id,
            'payment_method'  => $request->payment_method,
            'amount'          => $request->total_amount,
            'payment_status'  => $request->payment_status,
            'transaction_id'  => '', // Mã giao dịch ngẫu nhiên
            'payment_date'    => now()
        ]);

        DB::commit();

        // Điều hướng đến trang chi tiết đơn hàng
        return redirect()->route('admin.orders.edit', $order->id)
            ->with('success', 'Đặt hàng thành công! Mã đơn: ' . $order->order_code);
    }

    public function updateStatus(Request $request, Order $order)
    {

        $newStatus = $request->input('status');
        $currentStatus = $order->status;

        // Danh sách trạng thái hợp lệ và điều kiện chuyển đổi
        $validTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => []
        ];

        // Kiểm tra nếu trạng thái mới có trong danh sách hợp lệ
        if (!isset($validTransitions[$currentStatus]) || !in_array($newStatus, $validTransitions[$currentStatus])) {
            return redirect()->route('admin.orders.edit', $order->id)->with([
                'thongbao' => [
                    'type' => 'danger',
                    'message' => 'Trạng thái không hợp lệ.',
                ]
            ]);
        }
        StatusHistory::create([
            'entity_id' => $order->id,
            'entity_type' => 'order',
            'old_status' => $currentStatus,
            'new_status' => $newStatus,
            'changed_by' => auth()->user()->id, // Giả sử có người dùng đăng nhập
            'changed_at' => now(), // Thời gian thay đổi
        ]);

        // Cập nhật trạng thái
        $order->status = $newStatus;
        $order->save();

        return redirect()->route('admin.orders.edit', $order->id)->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Trạng thái đơn hàng đã được cập nhật thành công.',
            ]
        ]);
    }
}
