<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    public $fillable = ['siswa_id','tanggal','keluhan','tindakan','obat_id','petugas_id','status'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
