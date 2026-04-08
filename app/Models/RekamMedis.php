<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $fillable = ['siswa_id', 'tanggal', 'keluhan', 'tindakan', 'user_id', 'status'];
    protected $table = 'rekam_medis';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rekam_medis_obat()
    {
        return $this->hasMany(RekamMedisObat::class);
    }

}