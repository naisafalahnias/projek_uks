<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanGizi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PemeriksaanGiziController extends Controller
{
    public function index()
    {
        $pemeriksaan_gizi = PemeriksaanGizi::with('siswa', 'petugas')
                                ->latest()
                                ->get();

        return view('backend.pemeriksaan_gizi.index', compact('pemeriksaan_gizi'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        return view('backend.pemeriksaan_gizi.create', compact('siswas'));
    }

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
            'status' => 'draft' // default draft
        ]);

        return redirect()->route('backend.pemeriksaan_gizi.index')
            ->with('success', 'Data pemeriksaan gizi berhasil ditambahkan');
    }

    public function show($id)
    {
        $pemeriksaan = PemeriksaanGizi::with('siswa', 'petugas')->findOrFail($id);

        return view('backend.pemeriksaan_gizi.show', compact('pemeriksaan'));
    }

    public function edit($id)
    {
        $pemeriksaan = PemeriksaanGizi::findOrFail($id);
        $siswas = Siswa::all();

        return view('backend.pemeriksaan_gizi.edit', compact('pemeriksaan', 'siswas'));
    }

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

    public function destroy($id)
    {
        PemeriksaanGizi::findOrFail($id)->delete();

        return redirect()->route('backend.pemeriksaan_gizi.index')
            ->with('success', 'Data pemeriksaan gizi berhasil dihapus');
    }

    // 🔥 PUBLISH KE SISWA
    public function publish($id)
    {
        $pemeriksaan = PemeriksaanGizi::findOrFail($id);
        $pemeriksaan->update([
            'status' => 'published'
        ]);

        return back()->with('success', 'Laporan berhasil dipublish ke siswa');
    }

    // 🔥 EXPORT PDF
    public function exportPdf($id)
    {
        $pemeriksaan = PemeriksaanGizi::with('siswa')->findOrFail($id);

        $pdf = Pdf::loadView('backend.pemeriksaan_gizi.pdf', compact('pemeriksaan'));

        return $pdf->stream('laporan-gizi.pdf');
    }

    public function laporan(Request $request)
    {
        $query = PemeriksaanGizi::with('siswa', 'petugas');

        // Filter tanggal
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        // Filter siswa
        if ($request->siswa_id) {
            $query->where('siswa_id', $request->siswa_id);
        }

        $pemeriksaan_gizi = $query->latest()->get();
        $siswas = Siswa::all();

        return view('backend.pemeriksaan_gizi.laporan', compact('pemeriksaan_gizi', 'siswas'));
    }

}
