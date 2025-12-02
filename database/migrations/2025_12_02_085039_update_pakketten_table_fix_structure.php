<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pakketten', function (Blueprint $table) {

            // Track & trace toevoegen als hij nog niet bestaat
            if (!Schema::hasColumn('pakketten', 'track_and_trace')) {
                $table->string('track_and_trace')->nullable()->after('qr_code');
            }

            // Klant ID
            if (!Schema::hasColumn('pakketten', 'klant_id')) {
                $table->foreignId('klant_id')
                      ->nullable()
                      ->constrained('klanten')
                      ->onDelete('set null');
            }

            // Ontvanger ID
            if (!Schema::hasColumn('pakketten', 'ontvanger_id')) {
                $table->foreignId('ontvanger_id')
                      ->nullable()
                      ->constrained('ontvangers')
                      ->onDelete('set null');
            }

            // Leverancier ID
            if (!Schema::hasColumn('pakketten', 'leverancier_id')) {
                $table->foreignId('leverancier_id')
                      ->nullable()
                      ->constrained('leveranciers')
                      ->onDelete('set null');
            }

            // Route ID
            if (!Schema::hasColumn('pakketten', 'route_id')) {
                $table->foreignId('route_id')
                      ->nullable()
                      ->constrained('routes')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pakketten', function (Blueprint $table) {
            // rollback = verwijder deze kolommen (optioneel)
            if (Schema::hasColumn('pakketten', 'track_and_trace')) {
                $table->dropColumn('track_and_trace');
            }
            foreach (['klant_id','ontvanger_id','leverancier_id','route_id'] as $col) {
                if (Schema::hasColumn('pakketten', $col)) {
                    $table->dropForeign([$col]);
                    $table->dropColumn($col);
                }
            }
        });
    }
};
