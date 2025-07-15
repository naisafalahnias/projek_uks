<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // 🧾 Tampilkan semua siswa (admin: semua, petugas: milik sendiri)
    public function index()
    {
        $kelasList = Kelas::all();

        $siswas = auth()->user()->role === 'petugas'
            ? Siswa::with('kelas')->where('user_id', auth()->id())->get()
            : Siswa::with('kelas')->get();

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
            'nama' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $siswa  =   Siswa::create([
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'user_id' => auth()->id(), // 👈 Simpan siapa yang input
        ]);

        logAktivitas("Menambah Siswa {$siswa->nama}", 'siswa');

        return redirect()->route('backend.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    // 👀 Detail (kalau dipakai)
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('backend.siswa.show', compact('siswa'));
    }

    // ✏️ Form edit siswa
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();        
        return view('backend.siswa.edit', compact('siswa', 'kelas'));
    }

    // 🔄 Simpan perubahan siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);
        
        logAktivitas("Mengedit Siswa {$siswa->nama}", 'siswa');

        return redirect()->route('backend.siswa.index')->with('success', 'Data siswa berhasil diupdate.');
    }

    // 🗑️ Hapus siswa
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        logAktivitas("Menghapus Siswa {$siswa->nama}", 'siswa');

        return redirect()->route('backend.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $kelas   = $request->kelas;

        $query = Siswa::with('kelas');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%$keyword%")
                    ->orWhereHas('kelas', function ($q2) use ($keyword) {
                        $q2->where('nama_kelas', 'like', "%$keyword%");
                    });
            });
        }

        if ($kelas) {
            $query->whereHas('kelas', function ($q) use ($kelas) {
                $q->where('nama', $kelas);
            });
        }

        $siswas = $query->get();
        $view   = view('backend.siswa.search', compact('siswas'))->render();

        return response()->json(['data' => $view]);
    }
}
