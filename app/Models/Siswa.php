<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Siswa extends Model
{
    // Hapus 'user_id' dari sini karena kita pakainya 'siswa_id' di tabel users
    public $fillable = ['nama','tanggal_lahir', 'kelas_id', 'jenis_kelamin','user_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * RELASI PETUGAS INPUT
     * Ini untuk memanggil siapa Admin/Petugas yang menginput data ini.
     * Karena kolom 'user_id' ada di tabel 'siswas'
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * RELASI AKUN LOGIN SISWA
     * Jika kamu ingin tahu akun login (role siswa) milik siswa ini
     */
    public function akun()
    {
        return $this->hasOne(User::class, 'siswa_id');
    }

    public function rekam_medis(){
        return $this->hasMany(RekamMedis::class);
    }

    /**
     * Balikan Relasi: Satu profil siswa punya satu akun login (User)
     * Kita kasih tahu Laravel kalau foreign key-nya ada di tabel 'users' kolom 'siswa_id'
     */
    
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