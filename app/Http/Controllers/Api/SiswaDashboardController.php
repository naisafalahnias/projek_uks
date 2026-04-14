<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\RekamMedis;
use App\Models\PemeriksaanGizi;
use App\Models\JadwalPemeriksaan;
use App\Models\KondisiKesehatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SiswaDashboardController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // Pastikan yang login emang siswa (sesuai database kamu)
        if ($user->role !== 'siswa') {
            Auth::logout();
            return response()->json([
                'success' => false,
                'message' => 'Ini bukan akun siswa!'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'token' => $token,
            'user' => $user
        ]);
    }
    
    public function getDashboard(Request $request)
    {
        try {
            $user = auth()->user();
            $siswaId = $user->siswa_id;
            
            // Ambil data profil siswa & kelas (untuk jadwal)
            $siswa = Siswa::find($siswaId);

            if (!$siswa) {
                return response()->json(['success' => false, 'message' => 'Data siswa tidak ditemukan'], 404);
            }

            // 1. Rekam Medis (Terbaru & Count)
            $rekamTerbaru = RekamMedis::where('siswa_id', $siswaId)->latest()->first();
            $totalKunjungan = RekamMedis::where('siswa_id', $siswaId)->count();

            // 2. Gizi Terbaru
            $giziTerbaru = PemeriksaanGizi::where('siswa_id', $siswaId)
                ->where('status', 'published')
                ->latest()->first();

            // 3. Jadwal Mendatang (Menyontek logika web kamu)
            $jadwalMendatang = JadwalPemeriksaan::where('kelas_id', $siswa->kelas_id)
                ->where('tanggal', '>=', now())
                ->orderBy('tanggal', 'asc')
                ->take(3) // Ambil 3 saja buat ringkasan dashboard
                ->get();

            // 4. Kondisi Kesehatan (Alert)
            $kondisiKesehatan = KondisiKesehatan::where('siswa_id', $siswaId)->first();

            return response()->json([
                'success' => true,
                'data' => [
                    'siswa' => [
                        'nama' => $siswa->nama,
                        'kelas' => $siswa->kelas->nama_kelas ?? '-',
                    ],
                    'total_kunjungan' => $totalKunjungan,
                    'rekam_terbaru' => $rekamTerbaru,
                    'gizi_terbaru' => $giziTerbaru,
                    'jadwal_mendatang' => $jadwalMendatang,
                    'kondisi_kesehatan' => $kondisiKesehatan,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}