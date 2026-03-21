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
            $table->string('day', 50);
            $table->time('open_time');
            $table->time('close_time');
            $table->unsignedInteger('capacity')->nullable();
            $table->string('best_time')->nullable();
            $table->text('parking_info')->nullable();
            $table->text('transport_info')->nullable();
            $table->text('route_info')->nullable();
            $table->text('weather_embed')->nullable();
            $table->boolean('is_active')->default(true);
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
