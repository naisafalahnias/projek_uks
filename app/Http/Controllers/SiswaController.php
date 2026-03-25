<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $kelasList = Kelas::all();

        // Hapus pengecekan role petugas agar semua data muncul
        $siswas = Siswa::with(['kelas', 'user'])->get(); 

        return view('backend.siswa.index', compact('siswas', 'kelasList'));
    }

    // ➕ Tampilkan form tambah siswa
    public function create()
    {
        $kelas = Kelas::all();        
        return view('backend.siswa.create', compact('kelas'));
    }

    // 💾 Simpan data baru siswa
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date|before:today', // Rule ini yang bikin error tadi
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'tanggal_lahir.required' => 'Kolom tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Format tanggal lahir tidak valid. Tanggal harus sebelum hari ini.',
            'nama.required' => 'Nama lengkap siswa wajib diisi.',
            'kelas_id.required' => 'Silakan pilih kelas terlebih dahulu.',
            'kelas_id.exists' => 'Data kelas yang dipilih tidak terdaftar di sistem.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        logAktivitas("Menambah Siswa {$siswa->nama}", 'siswa');

        return redirect()->route('backend.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    // ✏️ Form edit siswa (Pakai Route Model Binding Siswa $siswa)
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('backend.siswa.edit', compact('siswa', 'kelas'));
    }

    // 🔄 Simpan perubahan siswa
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date|before:today',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        // Cek apakah ada perubahan data (biar gak mubazir log-nya)
        if ($request->nama == $siswa->nama && 
            $request->kelas_id == $siswa->kelas_id && 
            $request->jenis_kelamin == $siswa->jenis_kelamin &&
            $request->tanggal_lahir == $siswa->tanggal_lahir) {
            return redirect()->route('backend.siswa.index')->with('info', 'Tidak ada perubahan data.');
        }

        $siswa->update($request->only([
            'nama', 'tanggal_lahir', 'kelas_id', 'jenis_kelamin'
        ]));

        logAktivitas("Mengedit Siswa {$siswa->nama}", 'siswa');

        return redirect()->route('backend.siswa.index')
            ->with('success', 'Data siswa berhasil diupdate.');
    }

    // 🗑️ Hapus siswa
    public function destroy(Siswa $siswa)
    {
        // Hanya admin atau penginput asli yang boleh hapus
        if (auth()->user()->role !== 'admin' && $siswa->user_id !== auth()->id()) {
            return back()->with('error', 'Kamu tidak boleh menghapus data siswa inputan orang lain!');
        }
        $namaSiswa = $siswa->nama;
        $siswa->delete();

        logAktivitas("Menghapus Siswa {$namaSiswa}", 'siswa');

        return redirect()->route('backend.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    // 🔍 Search (Ajax)
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $kelas   = $request->kelas;

        $query = Siswa::with(['kelas','user']);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%$keyword%")
                    ->orWhereHas('kelas', function ($q2) use ($keyword) {
                        $q2->where('nama_kelas', 'like', "%$keyword%");
                    });
            });
        }

        if ($kelas) {
            $query->where('kelas_id', $kelas);
        }

        $siswas = $query->get();
        $view   = view('backend.siswa.search', compact('siswas'))->render();

        return response()->json(['data' => $view]);
    }
}