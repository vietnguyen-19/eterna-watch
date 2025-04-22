<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use App\Models\RefundItem;
use App\Models\StatusHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function create($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'orderItems.productVariant.attributeValues.nameValue', 'entity', 'payment', 'voucher'])->findOrFail($id);
        if ($order->user_id !== auth()->id() || $order->status !== 'completed') {
            abort(403, 'Bạn không thể hoàn hàng đơn này.');
        }

        return view('client.account.refund', compact('order'));
    }


    public function store(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'reason' => 'required|string',
            'refund_quantity' => 'required|array',
        ]);

        // 1. Tạo refund mới
        $refund = Refund::create([
            'order_id' => $order->id,
            'reason' => $validated['reason'],
            'status' => 'pending', // trạng thái ban đầu
            'total_refund_amount' => 0,
        ]);

        // 2. Tính tổng tiền hoàn lại
        $totalAmount = 0;
        foreach ($validated['refund_quantity'] as $orderItemId => $qty) {
            $orderItem = $order->orderItems()->where('id', $orderItemId)->first();
            if (!$orderItem || $qty <= 0 || $qty > $orderItem->quantity) continue;

            RefundItem::create([
                'refund_id' => $refund->id,
                'order_item_id' => $orderItem->id,
                'quantity' => $qty,
                'unit_price' => $orderItem->unit_price,
            ]);

            $totalAmount += $qty * $orderItem->unit_price;
        }

        $refund->update(['total_refund_amount' => $totalAmount]);

        // 3. Ghi nhận lịch sử trạng thái
        StatusHistory::create([
            'entity_id'   => $refund->id,
            'entity_type' => 'refund',
            'old_status'  => 'pending',
            'new_status'  => 'pending',
            'changed_by'  => $refund->order->user->id,
            'changed_at'  => Carbon::now(),
        ]);

        return redirect()
            ->route('account.order_detail', $order->id)
            ->with('success', 'Yêu cầu hoàn hàng đã được gửi!');
    }
}
