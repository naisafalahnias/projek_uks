<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanGizi extends Model
{
    protected $fillable = ['siswa_id','tanggal','berat_badan','tinggi_badan','bmi','status_gizi','keterangan','petugas_id'];

    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }

    public function petugas() {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
