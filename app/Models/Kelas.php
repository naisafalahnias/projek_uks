<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    public $fillable = ['nama_kelas'];

    public function jadwal_pemeriksaan(){
        return $this->hasMany(JadwalPemeriksaan::class);
    }
}
