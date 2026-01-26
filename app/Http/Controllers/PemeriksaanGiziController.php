<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanGizi;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class PemeriksaanGiziController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemeriksaan_gizi = PemeriksaanGizi::with('siswa', 'petugas')->latest()->get();
        return view('backend.pemeriksaan_gizi.index', compact('pemeriksaan_gizi'));
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
            'keterangan' => 'nullable|string',
        ]);

        $bmi = $request->berat_badan / pow(($request->tinggi_badan / 100), 2);

        PemeriksaanGizi::create([
            'siswa_id' => $request->siswa_id,
            'tanggal' => $request->tanggal,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'bmi' => round($bmi, 2),
            'keterangan' => $request->keterangan,
            'petugas_id' => auth()->id(),
        ]);

        return redirect()->route('backend.pemeriksaan_gizi.index')
            ->with('success', 'Data pemeriksaan gizi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pemeriksaan = PemeriksaanGizi::with('siswa')->findOrFail($id);
        return view('backend.pemeriksaan_gizi.show', compact('pemeriksaan_gizi'));
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
            'keterangan' => 'nullable|string',
        ]);

        $bmi = $request->berat_badan / pow(($request->tinggi_badan / 100), 2);

        $pemeriksaan = PemeriksaanGizi::findOrFail($id);
        $pemeriksaan->update([
            'siswa_id' => $request->siswa_id,
            'tanggal' => $request->tanggal,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'bmi' => round($bmi, 2),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('backend.pemeriksaan_gizi.index')
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
