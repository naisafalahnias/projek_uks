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
        Schema::table('pemeriksaan_gizis', function (Blueprint $table) {
            // Kita kasih default 'published' biar data lama nggak ilang
            $table->string('status')->default('published')->after('siswa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaan_gizis', function (Blueprint $table) {
            //
        });
    }
};
