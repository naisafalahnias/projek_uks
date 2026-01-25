<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Siswa extends Model
{
    public $fillable = ['nama','tanggal_lahir', 'kelas_id', 'jenis_kelamin','user_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function rekam_medis(){
        return $this->hasMany(RekamMedis::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUsiaAttribute()
    {
        return $this->tanggal_lahir
            ? Carbon::parse($this->tanggal_lahir)->age
            : null;
    }

    public function pemeriksaan_gizi(){
        return $this->hasMany(PemeriksaanGizi::class);
    }

    public function konsumsi_makanan(){
        return $this->hasMany(KonsumsiMakanan::class);
    }

    public function kondisi_kesehatan(){
        return $this->hasMany(KondisiKesehatan::class);
    }

}
