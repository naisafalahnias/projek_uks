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
        Schema::create('rekam_medis_obats', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rekam_medis_id');
            $table->unsignedBigInteger('obat_id');
            $table->integer('jumlah');

            // relasi
            $table->foreign('rekam_medis_id')
                ->references('id')
                ->on('rekam_medis')
                ->onDelete('cascade');

            $table->foreign('obat_id')
                ->references('id')
                ->on('obats')
                ->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis_obats');
    }
};
