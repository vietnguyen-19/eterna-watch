<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
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

        return view('client.account.partials.refund', compact('order'));
    }

    public function store(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'refund_reason' => 'required|string',
            'refund_quantity' => 'required|array',
            'refund_quantity.*' => 'nullable|integer|min:0',
            'total_refund_amount' => 'required|numeric',
        ]);

        // Kiểm tra total_refund_amount > 0
        if ($validated['total_refund_amount'] <= 0) {
            return back()
                ->withErrors(['total_refund_amount' => 'Bạn cần chọn sản phẩm hoàn hàng'])
                ->withInput();
        }

        // 1. Tạo refund mới
        $refund = Refund::create([
            'order_id' => $order->id,
            'refund_reason' => $validated['refund_reason'],
            'status' => 'pending',
            'total_refund_amount' => $validated['total_refund_amount'],
        ]);

        // 2. Tạo các bản ghi refund_items
        foreach ($validated['refund_quantity'] as $orderItemId => $quantity) {
            if ($quantity > 0) {
                $orderItem = OrderItem::find($orderItemId);
                if ($orderItem) {
                    RefundItem::create([
                        'refund_id' => $refund->id,
                        'order_item_id' => $orderItem->id,
                        'quantity' => $quantity,
                        'unit_price' => $orderItem->unit_price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

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
