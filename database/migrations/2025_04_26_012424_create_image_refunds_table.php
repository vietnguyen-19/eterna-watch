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
        Schema::create('image_refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refund_id');  // Khóa ngoại liên kết với bảng refunds
            $table->string('image');  // Đường dẫn ảnh
            $table->timestamps();

            // Khóa ngoại liên kết với bảng refunds
            $table->foreign('refund_id')->references('id')->on('refunds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_refunds');
    }
};
