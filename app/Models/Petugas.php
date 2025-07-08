<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    public $fillable = ['nama','user_id','no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function rekam_medis()
    {
        return $this->HasMany(RekamMedis::class);
    }
}
