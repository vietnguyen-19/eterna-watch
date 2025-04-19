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
        Schema::create('refund_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refund_id');
            $table->unsignedBigInteger('order_item_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2); // price at the time of refund
            $table->timestamps();
        
            $table->foreign('refund_id')->references('id')->on('refunds')->onDelete('cascade');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_items');
    }
};
