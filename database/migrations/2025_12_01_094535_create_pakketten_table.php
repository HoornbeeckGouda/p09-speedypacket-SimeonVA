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
        Schema::create('pakketten', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code')->unique();
            $table->string('status');
            $table->date('verwachte_leverdatum')->nullable();
            
            // Foreign keys
            $table->foreignId('klant_id')->constrained('klanten')->onDelete('cascade');
            $table->foreignId('ontvanger_id')->constrained('ontvangers')->onDelete('cascade');
            $table->foreignId('leverancier_id')->constrained('leveranciers')->onDelete('cascade');
            $table->foreignId('route_id')->nullable()->constrained('routes')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakketten');
    }
};