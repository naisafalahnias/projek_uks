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
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();

            // ID petugas yang melakukan aksi
            $table->unsignedBigInteger('user_id')->nullable();

            // Deskripsi aksi, misalnya 'Menambahkan Siswa'
            $table->string('aksi');

            // Nama tabel yang terkait (opsional)
            $table->string('tabel')->nullable();

            $table->timestamps();

            // Foreign key constraint ke tabel petugas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
