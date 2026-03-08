<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Nama fasilitas: "Pemandu Wisata", "Kamar Bilas"
            $table->text('description')->nullable();   // Deskripsi detail
            $table->string('photo_path')->nullable();  // Foto fasilitas
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
