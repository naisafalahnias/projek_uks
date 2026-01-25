<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanans';

    protected $fillable = ['nama_makanan','jenis','kalori','gula','lemak','status'];

    public function konsumsi_makanan()
    {
        return $this->hasMany(KonsumsiMakanan::class);
    }
}
