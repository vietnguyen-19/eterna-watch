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
        Schema::create('status_history', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('entity_id'); // ID của thực thể
            $table->enum('entity_type', ['order', 'payment', 'shipment']); // Loại thực thể
            $table->string('old_status', 50);
            $table->string('new_status', 50);
            $table->unsignedBigInteger('changed_by'); // Người thực hiện thay đổi
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();

            // Khóa ngoại tham chiếu đến bảng users (nếu cần)
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_history');
    }
};
