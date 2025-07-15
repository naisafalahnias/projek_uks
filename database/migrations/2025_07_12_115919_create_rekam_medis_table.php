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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->date('tanggal');
            $table->text('keluhan');
            $table->string('tindakan');
            $table->unsignedBigInteger('obat_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status');

            //relasi ini yh
            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->foreign('obat_id')->references('id')->on('obats');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};