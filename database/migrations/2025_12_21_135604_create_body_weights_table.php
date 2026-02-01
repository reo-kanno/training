<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('body_weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->decimal('weight', 5, 2); // 体重
            $table->decimal('body_fat_percentage', 4, 2)->nullable(); // 体脂肪率
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('body_weights');
    }
};