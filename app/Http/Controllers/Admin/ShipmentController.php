<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Services\GhnService;


class ShipmentController extends Controller
{
    public function store(Request $request, $orderId)
    {
        $request->validate([
            'shipping_cost' => 'required|string|max:255',
        ]);
    
        $order = Order::findOrFail($orderId);
    
        if ($order->shipment) {
            return back()->with('thongbao', [
                'type' => 'warning',
                'message' => 'Đơn hàng đã có thông tin vận chuyển.'
            ]);
        }
    
        $shipment = new Shipment();
        $shipment->order_id = $order->id;
        $shipment->shipping_cost = $request->shipment_provider;
        // $shipment->tracking_number = 'TRACK-' . strtoupper(uniqid());
        // $shipment->shipment_status = 'Chờ lấy hàng'; // trạng thái khởi tạo ban đầu
    
        $shipment->save();
    
        return back()->with('thongbao', [
            'type' => 'success',
            'message' => 'Đã tạo đơn vận chuyển thành công!'
        ]);
    }
}
