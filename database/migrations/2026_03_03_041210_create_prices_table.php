<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ticket', 'rental']); // tiket masuk / sewa fasilitas
            $table->decimal('amount', 12, 2);            // nominal harga
            $table->string('unit');                      // per orang / per jam / per hari
            $table->text('notes')->nullable();           // ketentuan / jam operasional
            $table->string('photo_path')->nullable();    // foto pendukung (opsional)
            $table->boolean('is_active')->default(true); // aktif / nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
