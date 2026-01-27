<?php

namespace App\Http\Controllers;

use App\Models\KondisiKesehatan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KondisiKesehatanController extends Controller
{
    public function index()
    {
        $kondisi_kesehatans = KondisiKesehatan::with('siswa')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('backend.kondisi_kesehatan.index', compact('kondisi_kesehatans'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        return view('backend.kondisi_kesehatan.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_kondisi' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        KondisiKesehatan::create([
            'siswa_id' => $request->siswa_id,
            'nama_kondisi' => $request->nama_kondisi,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('backend.kondisi_kesehatan.index')
            ->with('success', 'Data kondisi kesehatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kondisi = KondisiKesehatan::findOrFail($id);
        $siswas = Siswa::all();

        return view('backend.kondisi_kesehatan.edit', compact('kondisi', 'siswas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_kondisi' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $kondisi = KondisiKesehatan::findOrFail($id);
        $kondisi->update([
            'siswa_id' => $request->siswa_id,
            'nama_kondisi' => $request->nama_kondisi,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('backend.kondisi_kesehatan.index')
            ->with('success', 'Data kondisi kesehatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        KondisiKesehatan::findOrFail($id)->delete();

        return back()->with('success', 'Data kondisi kesehatan berhasil dihapus');
    }
}
