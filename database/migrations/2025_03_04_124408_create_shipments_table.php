<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id('id'); // AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('order_id'); // Khóa ngoại liên kết với bảng orders
            $table->string('shipping_provider', 100); // Nhà vận chuyển
            $table->enum('shipping_method', ['standard', 'express', 'same_day']); // Phương thức vận chuyển
            $table->decimal('shipping_cost', 10, 2); // Chi phí vận chuyển
            $table->string('tracking_number', 100)->nullable(); // Mã vận đơn (có thể có hoặc không)
            $table->enum('shipment_status', ['pending', 'shipped', 'delivered', 'cancelled'])
                ->default('pending'); // Trạng thái vận chuyển
            $table->timestamp('shipped_date')->nullable(); // Ngày xuất kho
            $table->timestamp('delivered_date')->nullable(); // Ngày giao hàng thành công
            $table->timestamp('estimated_delivery_date')->nullable(); // Ngày dự kiến giao hàng
            $table->timestamps(); // created_at & updated_at

            // Khóa ngoại
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
