<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_log_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained();
            $table->integer('sets'); // セット数
            $table->integer('reps'); // 回数
            $table->decimal('weight', 5, 2)->nullable(); // 重量
            $table->text('memo')->nullable();
            $table->integer('order')->default(0); // 表示順
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_exercises');
    }
};