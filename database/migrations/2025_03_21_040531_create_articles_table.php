<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');           // Tiêu đề bài viết
            $table->text('content');           // Nội dung bài viết
            $table->string('image')->nullable(); // Hình ảnh bài viết
            $table->string('author')->nullable(); // Tác giả
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
