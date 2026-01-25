<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\RekamMedis;
use App\Models\Siswa;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Models\Kelas;
use App\Models\RekamMedisObat;
use App\Exports\RekamMedisExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class RekamMedisController extends Controller
{
    public function index()
    {
        $rekam_medis = RekamMedis::with('siswa.kelas', 'rekam_medis_obat.obat', 'user')->latest()->get();
        return view('backend.rekam_medis.index', compact('rekam_medis'));
    }

    public function create()
    {
        $obat  = Obat::all();
        $kelas = Kelas::all();
        return view('backend.rekam_medis.create', compact('obat', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'tanggal' => 'required|date',
            'keluhan' => 'required',
            'tindakan' => 'required',
            'status' => 'required',
            'obat_id' => 'nullable|exists:obats,id',
            'jumlah' => 'nullable|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            // simpan rekam medis
            $rekamMedis = RekamMedis::create([
                'siswa_id' => $request->siswa_id,
                'tanggal' => $request->tanggal,
                'keluhan' => $request->keluhan,
                'tindakan' => $request->tindakan,
                'status' => $request->status,
                'user_id' => auth()->id(),
            ]);

            // kalau ada obat
            if ($request->obat_id && $request->jumlah) {
                $obat = Obat::lockForUpdate()->findOrFail($request->obat_id);

                if ($obat->stok < $request->jumlah) {
                    throw new \Exception('Stok obat tidak mencukupi');
                }

                // simpan ke tabel rekam_medis_obat
                RekamMedisObat::create([
                    'rekam_medis_id' => $rekamMedis->id,
                    'obat_id' => $obat->id,
                    'jumlah' => $request->jumlah,
                ]);

                // kurangi stok
                $obat->decrement('stok', $request->jumlah);
            }

            DB::commit();
            return redirect()->route('backend.rekam_medis.index')
                ->with('success', 'Rekam medis berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        $rekam_medis = RekamMedis::with('siswa.kelas', 'rekam_medis_obat.obat', 'user')->findOrFail($id);
        return view('backend.rekam_medis.show', compact('rekam_medis'));
    }

    public function edit(string $id)
    {
        $rekam_medis = RekamMedis::with(['siswa', 'obat'])->findOrFail($id);
        $obat = Obat::all();
        return view('backend.rekam_medis.edit', compact('rekam_medis', 'obat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keluhan' => 'required',
            'tindakan' => 'required',
            'status' => 'required',
            'obat_id' => 'nullable|exists:obats,id',
        ]);

        $rekam_medis = RekamMedis::findOrFail($id);

        $rekam_medis->update([
            'tanggal' => $request->tanggal,
            'keluhan' => $request->keluhan,
            'tindakan' => $request->tindakan,
            'status' => $request->status,
            'obat_id' => $request->obat_id,
        ]);

        return redirect()
            ->route('backend.rekam_medis.index')
            ->with('success', 'Data rekam medis berhasil diubah');
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $rekam_medis = RekamMedis::with('rekam_medis_obat.obat')->findOrFail($id);

            $nama = $rekam_medis->siswa->nama;
            $tanggal = $rekam_medis->tanggal;

            // balikin stok obat
            foreach ($rekam_medis->rekam_medis_obat as $item) {
                $item->obat->increment('stok', $item->jumlah);
            }

            // hapus detail obat
            $rekam_medis->rekam_medis_obat()->delete();

            // hapus rekam medis
            $rekam_medis->delete();

            DB::commit();

            logAktivitas(
                "Menghapus rekam medis siswa {$nama} tanggal {$tanggal}",
                'rekam_medis'
            );

            return redirect()
                ->route('backend.rekam_medis.index')
                ->with('success', 'Data berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function getSiswaByKelas($kelas_id)
    {
        $siswas = Siswa::where('kelas_id', $kelas_id)->get(['id', 'nama']);
        return response()->json($siswas);
    }

    public function laporan(Request $request)
    {
        $query = RekamMedis::with('siswa.kelas');
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        $rekam_medis = $query->latest()->get();
        return view('backend.rekam_medis.laporan', compact('rekam_medis'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new RekamMedisExport($request->tanggal_awal, $request->tanggal_akhir), 'laporan-rekam-medis.xlsx');
    }
}
