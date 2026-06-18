<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100);
            $table->decimal('amount', 12, 2);
            $table->string('unit', 50)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('media_id')
                  ->nullable()
                  ->constrained('media')
                  ->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('prices'); }
};
