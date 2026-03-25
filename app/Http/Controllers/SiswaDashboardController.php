<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\RekamMedis;
use App\Models\PemeriksaanGizi;
use App\Models\JadwalPemeriksaan;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaDashboardController extends Controller
{
    /**
     * Helper untuk ambil data siswa yang login biar gak ngetik berulang
     */
    private function getSiswa()
    {
        return Siswa::findOrFail(Auth::user()->siswa_id);
    }

    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::with('kelas')->find($user->siswa_id);

        if (!$siswa) {
            return "Akun Anda belum dihubungkan ke data profil Siswa. Hubungi Admin.";
        }
        
        // 1. Variabel Angka (Untuk Card "Total Pemeriksaan")
        $rekamMedisCount = RekamMedis::where('siswa_id', $siswa->id)->count(); 
        
        // 2. Variabel Data (Untuk Tabel "Pemeriksaan Terbaru") 
        // INI YANG TADI KURANG: Kita ambil datanya, bukan cuma hitung jumlahnya.
        $rekamMedis = RekamMedis::where('siswa_id', $siswa->id)
                        ->latest('tanggal')
                        ->take(5)
                        ->get();
               
        $riwayatGizi = PemeriksaanGizi::where('siswa_id', $siswa->id)
                        ->where('status', 'published') 
                        ->latest('tanggal')
                        ->take(5)
                        ->get();

        $giziTerakhir = $riwayatGizi->first();

        $jadwalMendatang = JadwalPemeriksaan::where('kelas_id', $siswa->kelas_id)
                            ->where('tanggal', '>=', now())
                            ->orderBy('tanggal', 'asc')
                            ->get();

        // Pastikan 'rekamMedis' (datanya) masuk ke compact
        return view('tes_dashboard.siswa', compact(
            'siswa',
            'rekamMedisCount', 
            'rekamMedis', 
            'giziTerakhir',
            'riwayatGizi',
            'jadwalMendatang'
        ));
    }
    
    public function rekamMedis()
    {
        $siswa = $this->getSiswa(); //
        
        // Sesuaikan nama variabel menjadi $rekam_medis (pakai underscore)
        $rekam_medis = RekamMedis::where('siswa_id', $siswa->id)
                        ->with('siswa.kelas', 'rekam_medis_obat.obat', 'user') // Tambahkan with agar datanya lengkap seperti di Admin
                        ->latest('tanggal')
                        ->get();
        // Panggil view backend admin
        return view('backend.rekam_medis.index', compact('siswa', 'rekam_medis'));
    }   

    public function downloadPdf($id)
    {
        $siswa = $this->getSiswa();
        
        // Ambil data tunggal
        $data_tunggal = RekamMedis::with('siswa.kelas')
                        ->where('id', $id)
                        ->where('siswa_id', $siswa->id)
                        ->firstOrFail();

        // Ubah ke format Collection (masukkan ke dalam array) 
        // supaya @forelse di blade tidak error
        $rekam_medis = collect([$data_tunggal]);

        // Panggil view backend
        $pdf = Pdf::loadView('backend.rekam_medis.pdf', compact('siswa', 'rekam_medis'));
        
        return $pdf->download("Rekam-Medis-{$siswa->nama}.pdf");
    }

    public function kaloriPdf($id)
    {
        $siswa = $this->getSiswa();
        $gizi = PemeriksaanGizi::where('id', $id)
                ->where('siswa_id', $siswa->id)
                ->where('status', 'published')
                ->firstOrFail();

        $pdf = Pdf::loadView('siswa.gizi.pdf', compact('siswa', 'gizi'));
        return $pdf->download("Kebutuhan-Kalori-{$siswa->nama}.pdf");
    }

    public function pemeriksaanGizi()
    {
        $siswa = $this->getSiswa();
        
        // 1. Ambil status gizi terakhir buat ditampilin di widget atas
        $giziTerakhir = PemeriksaanGizi::where('siswa_id', $siswa->id)
                        ->where('status', 'published')
                        ->latest('tanggal')
                        ->first();

        // 2. Ambil data Kebutuhan Kalori (ini yang jadi tabel utama)
        // Sesuaikan 'pemeriksaan_kalori' dengan nama tabel/model kamu di backend admin
        $pemeriksaan_kalori = \App\Models\PemeriksaanKalori::where('siswa_id', $siswa->id)
                            ->latest('tanggal')
                            ->get();

        // Kita tetap arahkan ke view backend admin agar tampilannya seragam
        return view('backend.pemeriksaan_kalori.index', compact('giziTerakhir', 'pemeriksaan_kalori', 'siswa'));
    }
}