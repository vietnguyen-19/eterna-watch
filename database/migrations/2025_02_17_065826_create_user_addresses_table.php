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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('full_name', 255);
            $table->string('phone_number', 15);
            $table->string('email', 255)->nullable();
            $table->string('street_address', 255);
            $table->string('ward', 100);
            $table->string('district', 100);
            $table->string('city', 100);
            $table->string('country', 100)->default('Việt Nam');
            $table->boolean('is_default')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
