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
            // Bernard-style: kolom toevoegen
            $table->string('track_and_trace')
                ->nullable()
                ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pakketten', function (Blueprint $table) {
            // Bernard-style: veilige rollback
            $table->dropColumn('track_and_trace');
        });
    }
};
