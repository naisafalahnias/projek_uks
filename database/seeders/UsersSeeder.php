<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        User::create([
            'name' => 'Admin Uks',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('ukssisehat'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Petugas UKS',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('rahasia'),
            'role' => 'petugas'
        ]);

        User::create([
            'name' => 'Siswa Sehat',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('rahasia'),
            'role' => 'siswa'
        ]);
    }
}