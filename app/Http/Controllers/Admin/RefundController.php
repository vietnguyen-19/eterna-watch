<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\StatusHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        $query = Refund::with('order.user');

        // Lọc theo trạng thái nếu không phải "all"
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Lấy danh sách refund theo điều kiện
        $refunds = $query->latest()->get();

        // Đếm số lượng từng loại trạng thái
        $statusCounts = [
            'all' => Refund::count(),
            'pending' => Refund::where('status', 'pending')->count(),
            'approved' => Refund::where('status', 'approved')->count(),
            'rejected' => Refund::where('status', 'rejected')->count(),
        ];

        return view('admin.refunds.index', compact('refunds', 'status', 'statusCounts'));
    }


    public function show(Refund $refund)
    {
        $refund->load('refundItems.orderItem.productVariant.product', 'order.user', 'order.address');
        $statusHistories = StatusHistory::where('entity_id', $refund->id)
            ->where('entity_type', 'refund')
            ->orderBy('changed_at', 'desc')  // Sắp xếp theo thời gian thay đổi
            ->get();
        return view('admin.refunds.show', compact('refund', 'statusHistories'));
    }

    public function approve(Refund $refund)
    {
        if ($refund->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý.');
        }

        // Cập nhật kho
        foreach ($refund->refundItems as $item) {
            $variant = $item->orderItem->productVariant;
            $variant->stock += $item->quantity;
            $variant->save();
        }

        // Ghi lại trạng thái cũ
        $oldStatus = $refund->status;

        // Cập nhật trạng thái mới
        $refund->status = 'approved';
        $refund->updated_at = now();
        $refund->save();

        // Ghi nhận lịch sử trạng thái
        StatusHistory::create([
            'entity_id'   => $refund->id,
            'entity_type' => 'refund',
            'old_status'  => $oldStatus,
            'new_status'  => 'approved',
            'changed_by'  => auth()->id(),
            'changed_at'  => Carbon::now(),
        ]);

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Yêu cầu đã được chấp nhận và cập nhật kho.');
    }
    public function reject(Request $request, Refund $refund)
    {
        if ($refund->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý.');
        }

        // Ghi lại trạng thái cũ
        $oldStatus = $refund->status;

        $refund->status = 'rejected';
        $refund->reason = $request->input('reason');
        $refund->save();

        // Ghi nhận lịch sử trạng thái
        StatusHistory::create([
            'entity_id'   => $refund->id,
            'entity_type' => 'refund',
            'old_status'  => $oldStatus,
            'new_status'  => 'rejected',
            'changed_by'  => auth()->id(),
            'note'  => $request->input('reason'),
            'changed_at'  => Carbon::now(),
        ]);

        return redirect()->route('admin.refunds.index')
            ->with('warning', 'Yêu cầu đã bị từ chối.');
    }
}
