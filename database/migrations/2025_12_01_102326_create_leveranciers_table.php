<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leveranciers', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('contactpersoon');
            $table->string('telefoon');
            $table->string('email');
            $table->string('adres');
            $table->string('postcode', 20);
            $table->string('plaats');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leveranciers');
    }
};
