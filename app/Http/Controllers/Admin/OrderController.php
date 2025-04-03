<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

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
        $orders = Order::with('orderItems')
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index',
             compact('orders', 'statusCounts', 'status'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.productVariant.product'])->findOrFail($id);

        return view('admin.order.show', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $allowedTransitions = [
            'pending'    => ['confirmed'],
            'confirmed'  => ['processing'],
            'processing' => ['completed'],
            'completed'  => [],
            'cancelled'  => [],
        ];

        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,completed,cancelled',
        ]);

        $current = $order->status;
        $newStatus = $request->status;

        if (!in_array($newStatus, $allowedTransitions[$current])) {
            return redirect()->back()->with('error', 'Không thể chuyển trạng thái từ "' . $current . '" sang "' . $newStatus . '"');
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->route('admin.orders.show', $id)->with('success', 'Trạng thái đã được cập nhật!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
