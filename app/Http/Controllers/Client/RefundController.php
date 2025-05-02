<?php

namespace App\Http\Controllers\Client;

use App\Helpers\ImageHandler;
use App\Http\Controllers\Controller;
use App\Models\ImageRefund;
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

            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            // Custom message tiếng Việt
            'refund_reason.required' => 'Vui lòng nhập lý do hoàn hàng.',
            'refund_reason.string' => 'Lý do hoàn hàng phải là dạng văn bản.',

            'refund_quantity.required' => 'Vui lòng nhập số lượng hoàn trả.',
            'refund_quantity.array' => 'Số lượng hoàn trả phải là một danh sách.',
            'refund_quantity.*.integer' => 'Số lượng hoàn phải là số nguyên.',
            'refund_quantity.*.min' => 'Số lượng hoàn trả tối thiểu là 0.',

            'total_refund_amount.required' => 'Vui lòng nhập tổng số tiền hoàn.',
            'total_refund_amount.numeric' => 'Tổng số tiền hoàn phải là số.',

            'images.required' => 'Vui lòng chọn ít nhất một hình ảnh minh chứng.',
            'images.array' => 'Hình ảnh phải được chọn dưới dạng danh sách.',

            'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
            'images.*.mimes' => 'Ảnh minh chứng phải có định dạng: jpeg, png, jpg, gif, svg, webp.',
            'images.*.max' => 'Mỗi ảnh minh chứng không được vượt quá 2MB.',
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
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = ImageHandler::saveImage($file, 'image_refunds');


                ImageRefund::create([
                    'refund_id' => $refund->id,
                    'image' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
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
