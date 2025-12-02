<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pakketten', function (Blueprint $table) {
            // Voeg kolommen toe zonder foreign keys eerst
            if (!Schema::hasColumn('pakketten', 'ontvanger_naam')) {
                $table->string('ontvanger_naam')->nullable();
            }
            
            if (!Schema::hasColumn('pakketten', 'ontvanger_email')) {
                $table->string('ontvanger_email')->nullable();
            }
            
            if (!Schema::hasColumn('pakketten', 'leverancier_naam')) {
                $table->string('leverancier_naam')->nullable();
            }
            
            if (!Schema::hasColumn('pakketten', 'leverancier_email')) {
                $table->string('leverancier_email')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pakketten', function (Blueprint $table) {
            $table->dropColumn(['ontvanger_naam', 'ontvanger_email', 'leverancier_naam', 'leverancier_email']);
        });
    }
};