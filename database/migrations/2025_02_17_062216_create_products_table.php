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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price_default', 15, 2);
            $table->decimal('price_sale', 15, 2)->nullable(); // Thêm cột giá khuyến mãi
            $table->enum('type', ['simple', 'variant'])->default('simple'); // Thêm loại sản phẩm
            $table->text('short_description');
            $table->text('full_description');
            $table->string('avatar');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
