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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id');
            $table->string('order_code', 50)->unique();
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('address_id')->constrained('user_addresses')->onDelete('cascade');


            $table->string('name'); // Tên người dung
            $table->string('order_user_id'); // Tên người dung
            // Thêm các trường lưu thông tin giao hàng

            $table->string('full_name'); // Tên người nhận
            $table->string('phone_number'); // Số điện thoại người nhận
            $table->string('email'); // Số điện thoại người nhận
            $table->string('street_address')->nullable(); // Địa chỉ phụ (phường, xã, khu phố)
            $table->string('ward'); // Phường
            $table->string('district'); // Quận, huyện
            $table->string('city'); // Thành phố

            $table->enum('payment_method', ['cash', 'vnpay'])->default('cash');
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->nullOnDelete();
            $table->decimal('total_amount', 15, 2)->default(0.00);
            $table->enum('status', ['pending', 'confirmed', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->enum('shipping_method', ['fixed', 'store', 'free'])->default('fixed');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
