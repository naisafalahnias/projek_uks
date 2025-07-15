<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('backend.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('backend.kelas.create');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'nama_kelas' => 'required',
        ]);

        $kelas  =   Kelas::create($request->only('nama_kelas'));

        logAktivitas("Menambah Kelas {$kelas->nama_kelas}", 'kelas');

        return redirect()->route('backend.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        logAktivitas("Menghapus Kelas {$kelas->nama_kelas}", 'kelas');

        return redirect()->route('backend.kelas.index')->with('success', 'Data Berhasil Dihapus');
    }
}
