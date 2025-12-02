<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pakketten', function (Blueprint $table) {
            // Foreign key naar users (ontvanger)
            $table->foreignId('ontvanger_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            
            // Foreign key naar leveranciers
            $table->foreignId('leverancier_id')
                  ->nullable()
                  ->constrained('leveranciers')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pakketten', function (Blueprint $table) {
            $table->dropForeign(['ontvanger_id']);
            $table->dropForeign(['leverancier_id']);
            $table->dropColumn(['ontvanger_id', 'leverancier_id']);
        });
    }
};