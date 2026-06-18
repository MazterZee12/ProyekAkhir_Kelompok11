<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('content')->nullable();
            $table->enum('type', ['event', 'promo', 'info'])->default('info');

            $table->foreignId('photo_media_id')
                  ->nullable()
                  ->constrained('media')
                  ->nullOnDelete();

            $table->foreignId('attachment_media_id')
                  ->nullable()
                  ->constrained('media')
                  ->nullOnDelete();

            $table->datetime('starts_at')->nullable();
            $table->datetime('ends_at')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->unsignedBigInteger('views')->default(0);

            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('announcements'); }
};
