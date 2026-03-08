<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');   // Foreign key ke users, jika user dihapus → review juga dihapus
            $table->tinyInteger('rating');                                      // Rating: 1-5
            $table->text('comment')->nullable();                                // Komentar ulasan
            $table->boolean('approved')->default(false);                     // Sudah disetujui admin? (true/false)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
