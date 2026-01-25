<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            // hapus FK dulu
            $table->dropForeign(['obat_id']);
            // baru hapus kolom
            $table->dropColumn('obat_id');
        });
    }

    public function down(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->unsignedBigInteger('obat_id');

            $table->foreign('obat_id')
                  ->references('id')
                  ->on('obats');
        });
    }
};
