<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();         // Alamat: "Jl. Pantai No. 1, Toba"
            $table->string('email')->nullable();           // Email: info@pasirputih.com
            $table->string('phone')->nullable();           // No. telepon: 0612-1234567
            $table->text('google_maps_embed')->nullable(); // Embed maps dari Google
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
