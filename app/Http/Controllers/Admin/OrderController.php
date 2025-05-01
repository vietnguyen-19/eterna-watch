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
        // Lấy các tham số lọc từ request
        $status = $request->input('status', 'all');
        $paymentStatus = $request->input('payment_status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $paymentMethod = $request->input('payment_method');

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

        // Xây dựng query lấy danh sách đơn hàng
        $query = Order::with(['orderItems', 'payment']);
      
        // Áp dụng bộ lọc trạng thái đơn hàng
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Áp dụng bộ lọc trạng thái thanh toán
        $query->when($paymentStatus, function ($q) use ($paymentStatus) {
            $q->whereHas('payment', function ($q2) use ($paymentStatus) {
                $q2->where('payment_status', $paymentStatus);
            });
        });

        $query->when($dateFrom, function ($q) use ($dateFrom) {
            $q->whereDate('created_at', '>=', $dateFrom);
        });

        $query->when($dateTo, function ($q) use ($dateTo) {
            $q->whereDate('created_at', '<=', $dateTo);
        });
        $query->when($paymentMethod, function ($q) use ($paymentMethod) {
            $q->where('payment_method', $paymentMethod);
        });



        // Lấy danh sách đơn hàng
        $orders = $query->orderBy('created_at', 'desc')->get();

        // Trả về view với các dữ liệu cần thiết
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

        $request->validate([
            'user_id'            => 'required|integer|exists:users,id',
            'name'               => 'required|string|max:255',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'required|string|max:20',
            'city'               => 'required|string|max:100',
            'district'           => 'required|string|max:100',
            'ward'               => 'required|string|max:100',
            'street_address'     => 'required|string|max:255',

            'order_items'        => 'required|array|min:1',
            'order_items.*.id'       => 'required|integer|exists:product_variants,id',
            'order_items.*.quantity' => 'required|integer|min:1',

            'total_amount'       => 'required|numeric|min:0',
            'voucher_id'         => 'nullable|integer|exists:vouchers,id',
            'shipping_method'    => 'required|string',
            'payment_method'     => 'required|string|in:cash,vnpay',
            'payment_status'     => 'required|string|in:pending,completed,failed',
        ]);


        $userId = $request->user_id;

        // Kiểm tra xem địa chỉ mới có giống với địa chỉ mặc định không
        $needCreateAddress = true;
        $defaultAddress = UserAddress::where('user_id', $userId)->where('is_default', true)->first();

        if ($defaultAddress) {
            $sameInfo = $defaultAddress->full_name === $request->name &&
                $defaultAddress->phone_number === $request->phone &&
                $defaultAddress->street_address === $request->specific_address &&
                $defaultAddress->ward === $request->ward &&
                $defaultAddress->district === $request->district &&
                $defaultAddress->city === $request->city;

            if ($sameInfo) {
                $needCreateAddress = false;
                $address_id = $defaultAddress->id;
            }
        }

        if ($needCreateAddress) {
            $address =  UserAddress::create([
                'user_id'        => $userId,
                'full_name'      => $request->name,
                'phone_number'   => $request->phone,
                'email'          => $request->email,
                'street_address' => $request->street_address,
                'ward'           => $request->ward,
                'district'       => $request->district,
                'city'           => $request->city,
                'country'        => 'Việt Nam',
                'is_default'     => false,
                'note'           => null,
            ]);
            $address_id = $address->id;
        }

        // Tạo đơn hàng
        $order = new Order();
        $order->user_id      = $userId;
        $order->voucher_id   = $request->voucher_id;
        $order->address_id   = $address_id;
        $order->total_amount = $request->total_amount;
        $order->status       = 'pending';
        $order->order_code   = 'ORD-' . time() . '-' . Str::upper(Str::random(5));
        $order->save();

        // Thêm các sản phẩm vào đơn hàng
        foreach ($request->order_items as $item) {
            $variant = ProductVariant::find($item['id']);

            if (!$variant || $variant->stock < $item['quantity']) {
                DB::rollBack();
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

        // Tăng số lần dùng của voucher nếu có
        if ($request->voucher_id) {
            Voucher::where('id', $request->voucher_id)->increment('used_count');
        }

        // Tạo thanh toán
        Payment::create([
            'order_id'        => $order->id,
            'payment_method'  => $request->payment_method,
            'amount'          => $request->total_amount,
            'payment_status'  => $request->payment_status,
            'transaction_id'  => '', // có thể generate mã nếu cần
            'payment_date'    => now()
        ]);

        DB::commit();

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
            return redirect()->route('admin.orders.edit', $order->id)->with('error', 'Trạng thái không hợp lệ.');
        }

        // Kiểm tra nếu phương thức thanh toán là tiền mặt và trạng thái chuyển sang completed
        if ($order->payment_method == 'cash' && $newStatus == 'completed') {

            $order->payment->update([
                'payment_status' => 'completed',
            ]);

            $st = StatusHistory::create([
                'entity_id' => $order->payment->id,
                'entity_type' => 'payment',
                'old_status' => 'pending',
                'new_status' => 'completed',
                'changed_by' => $order->user->id, // Giả sử có người dùng đăng nhập
                'changed_at' => now(), // Thời gian thay đổi
            ]);
        }

        // Ghi lại lịch sử trạng thái
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

        return redirect()->route('admin.orders.edit', $order->id)->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công.');
    }


    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Đã xoá đơn hàng tạm thời.');
    }

    // Danh sách đã xoá
    public function trash(Request $request)
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
        $orders = Order::onlyTrashed()
            ->with('orderItems')
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $orders = Order::onlyTrashed()->latest()->get();
        return view('admin.orders.trash', compact('orders', 'statusCounts', 'status'));
    }

    // Khôi phục
    public function restore($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->restore();
        return redirect()->route('admin.orders.trash')->with('success', 'Đã khôi phục đơn hàng.');
    }

    // Xoá vĩnh viễn
    public function forceDelete($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->forceDelete();
        return redirect()->route('admin.orders.trash')->with('success', 'Đã xoá vĩnh viễn đơn hàng.');
    }
}
