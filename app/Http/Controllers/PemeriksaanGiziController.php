<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanGizi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PemeriksaanGiziController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemeriksaan = PemeriksaanGizi::with('siswa')->latest()->get();
        return view('backend.pemeriksaan_gizi.index', compact('pemeriksaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswas = Siswa::all();
        return view('backend.pemeriksaan_gizi.create', compact('siswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'status_gizi' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        PemeriksaanGizi::create($request->all());

        return redirect()->route('backend.pemeriksaan_gizi.index')
            ->with('success', 'Data pemeriksaan gizi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pemeriksaan = PemeriksaanGizi::with('siswa')->findOrFail($id);
        return view('backend.pemeriksaan_gizi.show', compact('pemeriksaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pemeriksaan = PemeriksaanGizi::findOrFail($id);
        $siswas = Siswa::all();

        return view('backend.pemeriksaan_gizi.edit', compact('pemeriksaan', 'siswas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'status_gizi' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $pemeriksaan = PemeriksaanGizi::findOrFail($id);
        $pemeriksaan->update($request->all());

        return redirect()->route('pemeriksaan-gizi.index')
            ->with('success', 'Data pemeriksaan gizi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PemeriksaanGizi::findOrFail($id)->delete();

        return redirect()->route('pemeriksaan-gizi.index')
            ->with('success', 'Data pemeriksaan gizi berhasil dihapus');
    }
}
