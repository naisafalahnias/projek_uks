<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiKesehatan extends Model
{
    use HasFactory;

    protected $table = 'kondisi_kesehatan';

    protected $fillable = [
        'siswa_id',
        'nama_kondisi',
        'tanggal',
        'keterangan',
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
