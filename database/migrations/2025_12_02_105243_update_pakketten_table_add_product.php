<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pakketten', function (Blueprint $table) {
            // Verwijder leverancier_id als die bestaat
            if (Schema::hasColumn('pakketten', 'leverancier_id')) {
                $table->dropForeign(['leverancier_id']);
                $table->dropColumn('leverancier_id');
            }
            
            // Voeg product_id toe na ontvanger_id
            if (!Schema::hasColumn('pakketten', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable()->after('ontvanger_id');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pakketten', function (Blueprint $table) {
            // Verwijder product_id
            if (Schema::hasColumn('pakketten', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
            
            // Herstel leverancier_id
            if (!Schema::hasColumn('pakketten', 'leverancier_id')) {
                $table->unsignedBigInteger('leverancier_id')->nullable()->after('ontvanger_id');
                $table->foreign('leverancier_id')->references('id')->on('leveranciers')->onDelete('set null');
            }
        });
    }
};