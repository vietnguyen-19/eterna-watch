<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\StatusHistory;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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
        $orders = Order::with('orderItems.productVariant.product' )
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'admin.orders.index',
            compact('orders', 'statusCounts', 'status')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productVariants = ProductVariant::all(); // Lấy danh sách biến thể sản phẩm

        return view('admin.orders.create', compact('productVariants'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.productVariant.product'])->findOrFail($id);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'user.addresses', 'entity', 'payment', 'voucher'])->findOrFail($id);
        $statusHistories = StatusHistory::where('entity_id', $order->id)
            ->where('entity_type', 'order')
            ->orderBy('changed_at', 'desc')  // Sắp xếp theo thời gian thay đổi
            ->get();
        return view('admin.orders.edit', compact('order', 'statusHistories'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, Order $order)
    {

        $newStatus = $request->input('status');

        // Kiểm tra nếu không có trạng thái mới hoặc trạng thái không hợp lệ
        if (!$newStatus || !is_string($newStatus)) {
            return redirect()->route('admin.orders.edit', $order->id)->with([
                'thongbao' => [
                    'type' => 'danger',
                    'message' => 'Trạng thái không hợp lệ hoặc không được cung cấp.',
                ]
            ]);
        }

        $currentStatus = $order->status;
        $userId = auth()->id(); // Lấy ID của user hiện tại

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
                    'message' => 'Chuyển đổi Trạng thái không hợp lệ.',
                ]
            ]);
        }

        // Kiểm tra nếu trạng thái không thay đổi
        if ($newStatus === $currentStatus) {
            return redirect()->route('admin.orders.edit', $order->id)->with([
                'thongbao' => [
                    'type' => 'info',
                    'message' => 'Trạng thái đơn hàng không thay đổi.',
                ]
            ]);
        }

        try {
            DB::beginTransaction();

            // Lưu lịch sử trạng thái
            StatusHistory::create([
                'entity_id' => $order->id,
                'entity_type' => 'order',
                'old_status' => $currentStatus,
                'new_status' => $newStatus,
                'changed_by' => auth()->id() ?? 1, // Kiểm tra có user đăng nhập không
                'changed_at' => now(),
            ]);

            // Cập nhật trạng thái đơn hàng
            $order->status = $newStatus;
            $order->save();

            DB::commit();

            return redirect()->route('admin.orders.edit', $order->id)->with([
                'thongbao' => [
                    'type' => 'success',
                    'message' => 'Trạng thái đơn hàng đã được cập nhật thành công.',
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.orders.edit', $order->id)->with([
                'thongbao' => [
                    'type' => 'danger',
                    'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                ]
            ]);
        }

       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order) {}
}
