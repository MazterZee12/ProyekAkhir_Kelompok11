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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->text('history')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();

            $table->string('manager_name')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('manager_phone',50)->nullable();

            $table->string('logo_path')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
