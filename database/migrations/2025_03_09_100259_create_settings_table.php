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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique(); // Khóa duy nhất cho mỗi setting
        $table->text('value'); // Giá trị cài đặt, lưu chuỗi, số, JSON, v.v.
        $table->enum('type', ['string', 'number', 'boolean', 'json'])->default('string'); // Kiểu dữ liệu
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');

    }
};
