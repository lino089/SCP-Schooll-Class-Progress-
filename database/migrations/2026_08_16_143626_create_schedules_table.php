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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('school_classes');
            $table->foreignId('teacher_id')->constrained('users');
            // $table->foreignId('room_id')->constrained('rooms');
            $table->string('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('cycle_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
