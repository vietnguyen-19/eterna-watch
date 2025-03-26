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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            $table->string('name'); // Tên voucher
            $table->string('code')->unique(); // Mã voucher duy nhất
            $table->enum('discount_type', ['percent', 'fixed']); // Loại giảm giá
            $table->decimal('discount_value', 10, 2); // Giá trị giảm giá
            $table->decimal('min_order', 10, 2)->nullable(); // Giá trị đơn hàng tối thiểu
            $table->integer('max_uses')->nullable(); // Giới hạn số lần sử dụng
            $table->integer('used_count')->default(0); // Số lần đã sử dụng
            $table->dateTime('start_date')->nullable(); // Ngày bắt đầu
            $table->dateTime('expires_at')->nullable(); // Hạn sử dụng
            $table->enum('status', ['active', 'expired'])->default('active'); // Trạng thái
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
