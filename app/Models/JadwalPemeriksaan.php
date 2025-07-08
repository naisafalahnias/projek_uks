<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPemeriksaan extends Model
{
    public $fillable = ['tgl','kelas_id','petugas_id','keterangan'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
