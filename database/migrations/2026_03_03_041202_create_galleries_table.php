<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {

            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('file_path');

            $table->enum('type', ['photo','video'])->default('photo');
            $table->enum('status', ['draft','published'])->default('published');

            $table->timestamps();
            $table->softDeletes();

            $table->index('type');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
