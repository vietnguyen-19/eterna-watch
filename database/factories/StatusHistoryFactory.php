<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\StatusHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusHistory>
 */
class StatusHistoryFactory extends Factory
{
    protected $model = StatusHistory::class;

    // Danh sách trạng thái hợp lệ theo thứ tự
    protected $statusFlow = [
        'pending' => ['confirmed'],
        'confirmed' => ['processing'],
        'processing' => ['completed'],
        'completed' => [], // Không có trạng thái tiếp theo
        'cancelled' => []  // Hủy đơn xong thì không đổi trạng thái nữa
    ];

    public function definition(): array
    {
        $order = Order::query()->inRandomOrder()->first() ?? Order::factory()->create();

        $oldStatus = $order->status;
        $possibleNewStatuses = $this->statusFlow[$oldStatus];

        // Nếu trạng thái hiện tại không có trạng thái tiếp theo thì giữ nguyên
        $newStatus = empty($possibleNewStatuses) ? $oldStatus : $this->faker->randomElement($possibleNewStatuses);

        return [
            'entity_id' => $order->id,
            'entity_type' => 'order',
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'changed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
