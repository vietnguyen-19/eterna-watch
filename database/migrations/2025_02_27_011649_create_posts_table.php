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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('view_count')->nullable();
            $table->softDeletes(); // Thêm cột view_count
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
