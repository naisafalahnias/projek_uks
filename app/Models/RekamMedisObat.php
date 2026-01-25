<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedisObat extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis_obats';

    protected $fillable = [
        'rekam_medis_id',
        'obat_id',
        'jumlah',
    ];

    // relasi ke rekam medis
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }

    // relasi ke obat
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
