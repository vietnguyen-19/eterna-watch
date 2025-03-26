<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Lấy tất cả đơn hàng đã có
        $orders = Order::all();

        foreach ($orders as $order) {
            $shippingMethod = $this->randomShippingMethod();
            $shippingCost = $shippingMethod === 'fixed' ? 10000 : 0;

            // Random ngày shipped trong quá khứ (trong vòng 30 ngày gần đây)
            $shippedDate = Carbon::now()->subDays(rand(1, 30));

            // delivered_date = shipped_date + 3 đến 7 ngày
            $deliveredDate = $shippedDate->copy()->addDays(rand(3, 7));

            Shipment::create([
                'order_id'        => $order->id,
                'shipping_method' => $shippingMethod,
                'shipping_cost'   => $shippingCost,
                'shipped_date'    => $shippedDate,
                'delivered_date'  => $deliveredDate,
            ]);
        }
    }

    // Hàm chọn ngẫu nhiên phương thức vận chuyển
    private function randomShippingMethod()
    {
        return ['free', 'store', 'fixed'][array_rand(['free', 'store', 'fixed'])];
    }
}
