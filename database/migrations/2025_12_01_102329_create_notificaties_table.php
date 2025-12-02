<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaties', function (Blueprint $table) {
            $table->id();
            $table->text('bericht');
            $table->boolean('gelezen')->default(false);
            $table->string('notificatie_type');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pakket_id')->nullable()->constrained('pakketten')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaties');
    }
};