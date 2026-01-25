<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsumsiMakanan extends Model
{
    use HasFactory;

    protected $table = 'konsumsi_makanans';

    protected $fillable = [
        'siswa_id',
        'makanan_id',
        'tanggal',
        'jumlah',
        'total_kalori',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class);
    }
}
