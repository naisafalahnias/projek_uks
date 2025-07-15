<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPemeriksaan extends Model
{
    protected $table = 'jadwal_pemeriksaans'; // pastikan nama tabel benar

    public $fillable = ['tanggal', 'kelas_id', 'user_id', 'keterangan'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}