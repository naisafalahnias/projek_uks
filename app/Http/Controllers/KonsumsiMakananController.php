<?php

namespace App\Http\Controllers;

use App\Models\KonsumsiMakanan;
use App\Models\Siswa;
use App\Models\Makanan;
use Illuminate\Http\Request;

class KonsumsiMakananController extends Controller
{
    public function index()
    {
        $konsumsi = KonsumsiMakanan::with(['siswa', 'makanan'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('backend.konsumsi_makanan.index', compact('konsumsi'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        $makanans = Makanan::all();

        return view('backend.konsumsi_makanan.create', compact('siswas', 'makanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'makanan_id' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        $makanan = Makanan::findOrFail($request->makanan_id);
        $totalKalori = $makanan->kalori * $request->jumlah;

        KonsumsiMakanan::create([
            'siswa_id' => $request->siswa_id,
            'makanan_id' => $request->makanan_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'total_kalori' => $totalKalori,
        ]);

        return redirect()->route('backend.konsumsi_makanan.index')
            ->with('success', 'Data konsumsi makanan berhasil ditambahkan');
    }

    public function show($id)
    {
        $konsumsi = KonsumsiMakanan::with(['siswa', 'makanan'])->findOrFail($id);

        return view('backend.konsumsi_makanan.show', compact('konsumsi'));
    }

    public function edit($id)
    {
        $konsumsi = KonsumsiMakanan::findOrFail($id);
        $siswas = Siswa::all();
        $makanans = Makanan::all();

        return view('backend.konsumsi_makanan.edit', compact('konsumsi', 'siswas', 'makanans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required',
            'makanan_id' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        $makanan = Makanan::findOrFail($request->makanan_id);
        $totalKalori = $makanan->kalori * $request->jumlah;

        $konsumsi = KonsumsiMakanan::findOrFail($id);
        $konsumsi->update([
            'siswa_id' => $request->siswa_id,
            'makanan_id' => $request->makanan_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'total_kalori' => $totalKalori,
        ]);

        return redirect()->route('backend.konsumsi_makanan.index')
            ->with('success', 'Data konsumsi makanan berhasil diupdate');
    }

    public function destroy($id)
    {
        KonsumsiMakanan::findOrFail($id)->delete();

        return redirect()->route('backend.konsumsi_makanan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
