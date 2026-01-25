<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanKalori extends Model
{
    use HasFactory;

    protected $table = 'kebutuhan_kaloris';

    protected $fillable = [
        'siswa_id',
        'kebutuhan_harian',
        'tingkat_aktivitas',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
