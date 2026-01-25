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
        Schema::create('pemeriksaan_gizis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')
                  ->constrained('siswas')
                  ->cascadeOnDelete();

            $table->date('tanggal');

            $table->decimal('berat_badan', 8, 2);
            $table->decimal('tinggi_badan', 8, 2);
            $table->decimal('bmi', 8, 2);

            $table->text('keterangan')->nullable();

            // relasi ke user (petugas)
            $table->foreignId('petugas_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_gizis');
    }
};
