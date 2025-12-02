<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->date('datum');
            $table->string('rayon');
            $table->string('status_route');
            $table->json('anwb_roads_data')->nullable();
            $table->json('anwb_traffic')->nullable();
            $table->json('anwb_jams')->nullable();
            $table->dateTime('laatste_api_sync')->nullable();
            $table->foreignId('koerier_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};