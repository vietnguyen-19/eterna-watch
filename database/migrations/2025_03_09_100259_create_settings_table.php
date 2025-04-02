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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('language')->default('vi'); // Ngôn ngữ mặc định là tiếng Việt
            // Cài đặt thông báo
            $table->boolean('notification_email')->default(true);
            $table->boolean('notification_sms')->default(false);
            $table->boolean('notification_app')->default(true);
            // Cài đặt quyền riêng tư
            $table->string('privacy_profile')->default('public'); // public/friends/private
            $table->string('privacy_contact')->default('public');
            // Cài đặt giao diện
            $table->string('theme')->default('light'); // light/dark
            $table->string('layout')->default('default');
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
