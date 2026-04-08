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
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date|before:today',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'tanggal_lahir.required' => 'Kolom tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Format tanggal lahir tidak valid.',
            'nama.required' => 'Nama lengkap siswa wajib diisi.',
            'kelas_id.required' => 'Silakan pilih kelas terlebih dahulu.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        // Tambahkan ID user yang login sebagai penginput
        $data['user_id'] = auth()->id();

        // Cukup panggil ini. Log otomatis dibuat oleh SiswaObserver!
        Siswa::create($data); 

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

        // Biarkan Observer yang menangani log jika ada perubahan (isDirty)
        $siswa->update($request->only([
            'nama', 'tanggal_lahir', 'kelas_id', 'jenis_kelamin'
        ]));

        return redirect()->route('backend.siswa.index')
            ->with('success', 'Data siswa berhasil diupdate.');
    }

    // 🗑️ Hapus siswa
    public function destroy(Siswa $siswa)
    {
        if (auth()->user()->role !== 'admin' && $siswa->user_id !== auth()->id()) {
            return back()->with('error', 'Kamu tidak boleh menghapus data siswa inputan orang lain!');
        }

        // Observer otomatis mencatat log sebelum data benar-benar hilang
        $siswa->delete();

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