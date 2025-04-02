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
        Schema::create('adminsettings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Chìa khóa để xác định cài đặt
            $table->string('value'); // Giá trị của cài đặt
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adminsettings');
    }
};
