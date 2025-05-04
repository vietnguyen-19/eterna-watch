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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();

            // Liên kết đơn hàng
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            // Tổng số tiền hoàn lại
            $table->decimal('total_refund_amount', 12, 2)->default(0);

            // Lý do hoàn tiền và lý do từ chối (nếu có)
            $table->text('refund_reason')->nullable();
            $table->text('rejected_reason')->nullable();

            // Trạng thái xử lý nội bộ
            $table->enum('status', ['pending', 'approved', 'rejected', 'processing', 'refunded', 'failed'])
                ->default('pending');

            // Thông tin phản hồi từ VNPay (nếu có)
            $table->string('vnp_transaction_no')->nullable();      // Mã giao dịch hoàn tiền từ VNPay
            $table->string('vnp_response_code')->nullable();       // Mã phản hồi kết quả từ VNPay
            $table->timestamp('refunded_at')->nullable();          // Thời gian hoàn tiền thành công

            $table->timestamps();
        });
     
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
