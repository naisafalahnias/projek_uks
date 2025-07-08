<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    public $fillable = ['user_id', 'kelas', 'jenis_kelamin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
