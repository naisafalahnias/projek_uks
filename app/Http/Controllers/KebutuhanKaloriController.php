<?php

namespace App\Http\Controllers;

use App\Models\KebutuhanKalori;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KebutuhanKaloriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kebutuhanKalori = KebutuhanKalori::with('siswa')->latest()->get();

        return view('backend.kebutuhan_kalori.index', compact('kebutuhanKalori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswas = Siswa::orderBy('nama')->get();

        return view('backend.kebutuhan_kalori.create', compact('siswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'           => 'required|exists:siswas,id|unique:kebutuhan_kaloris,siswa_id',
            'kebutuhan_harian'   => 'required|integer|min:1',
            'tingkat_aktivitas'  => 'required|in:rendah,sedang,tinggi',
        ]);

        KebutuhanKalori::create([
            'siswa_id'          => $request->siswa_id,
            'kebutuhan_harian'  => $request->kebutuhan_harian,
            'tingkat_aktivitas' => $request->tingkat_aktivitas,
        ]);

        return redirect()
            ->route('backend.kebutuhan_kalori.index')
            ->with('success', 'Data kebutuhan kalori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kebutuhanKalori = KebutuhanKalori::with('siswa')->findOrFail($id);

        return view('backend.kebutuhan_kalori.show', compact('kebutuhanKalori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kebutuhanKalori = KebutuhanKalori::findOrFail($id);
        $siswas = Siswa::orderBy('nama')->get();

        return view('backend.kebutuhan_kalori.edit', compact('kebutuhanKalori', 'siswas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kebutuhanKalori = KebutuhanKalori::findOrFail($id);

        $request->validate([
            'siswa_id'           => 'required|exists:siswas,id|unique:kebutuhan_kaloris,siswa_id,' . $kebutuhanKalori->id,
            'kebutuhan_harian'   => 'required|integer|min:1',
            'tingkat_aktivitas'  => 'required|in:rendah,sedang,tinggi',
        ]);

        $kebutuhanKalori->update([
            'siswa_id'          => $request->siswa_id,
            'kebutuhan_harian'  => $request->kebutuhan_harian,
            'tingkat_aktivitas' => $request->tingkat_aktivitas,
        ]);

        return redirect()
            ->route('backend.kebutuhan_kalori.index')
            ->with('success', 'Data kebutuhan kalori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kebutuhanKalori = KebutuhanKalori::findOrFail($id);
        $kebutuhanKalori->delete();

        return redirect()
            ->route('backend.kebutuhan_kalori.index')
            ->with('success', 'Data kebutuhan kalori berhasil dihapus');
    }
}
