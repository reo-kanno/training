<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']); // 食事タイプ
            $table->string('meal_name');
            $table->integer('calories')->nullable();
            $table->decimal('protein', 5, 2)->nullable(); // タンパク質
            $table->decimal('carbs', 5, 2)->nullable(); // 炭水化物
            $table->decimal('fat', 5, 2)->nullable(); // 脂質
            $table->text('memo')->nullable();
            $table->string('image')->nullable(); // 画像パス
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_logs');
    }
};