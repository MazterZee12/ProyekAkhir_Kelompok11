<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->softDeletes();
            $table->unsignedInteger('reports_count')->default(0);
            $table->timestamp('hidden_at')->nullable(); // untuk auto-hide
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['reports_count', 'hidden_at']);
        });
    }
};
