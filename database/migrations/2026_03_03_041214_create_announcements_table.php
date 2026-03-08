<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');                                            // Judul: "Tutup Liburan", "Diskon 50%"
            $table->text('content');                                            // Isi pengumuman lengkap
            $table->enum('type', ['event', 'promo', 'info'])->default('info');  // Tipe: event, promo, info
            $table->dateTime('starts_at')->nullable();                          // Mulai berlaku: 2026-03-01 08:00:00
            $table->dateTime('ends_at')->nullable();                            // Selesai berlaku: 2026-03-31 17:00:00
            $table->string('photo_path')->nullable();                           // Tipe: event, promo, info
            $table->boolean('is_active')->default(true);
            $table->string('slug')->unique();
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->string('attachment_path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
