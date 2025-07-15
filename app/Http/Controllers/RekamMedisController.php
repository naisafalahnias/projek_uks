<?php
namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\RekamMedis;
use App\Models\Siswa;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Exports\RekamMedisExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class RekamMedisController extends Controller
{
    public function index()
    {
        $rekam_medis = RekamMedis::with('siswa.kelas', 'obat', 'user')->latest()->get();
        return view('backend.rekam_medis.index', compact('rekam_medis'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        $users = User::all();
        $obat  = Obat::all();

        return view('backend.rekam_medis.create', compact('siswa', 'users', 'obat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal'  => 'required|date',
            'keluhan'  => 'required|string',
            'tindakan' => 'required|string',
            'obat_id'  => 'nullable|exists:obats,id',
            'user_id'  => 'required|exists:users,id',
            'status'   => 'required|string',
        ]);

        $rekam = RekamMedis::create($validated);

        LogAktivitas("Menambahkan rekam medis siswa {$rekam->siswa->nama} pada tanggal {$rekam->tanggal}", 'rekam_medis');

        return redirect()->route('backend.rekam_medis.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $rekam_medis = RekamMedis::with('siswa.kelas', 'obat', 'user')->findOrFail($id);
        return view('backend.rekam_medis.show', compact('rekam_medis'));
    }

    public function edit(string $id)
    {
        $rekam_medis = RekamMedis::findOrFail($id);
        $siswa       = Siswa::with('user')->get();
        $users       = User::all();
        $obat        = Obat::all();

        return view('backend.rekam_medis.edit', compact('rekam_medis', 'siswa', 'users', 'obat'));
    }

    public function update(Request $request, string $id)
    {
        $rekam_medis = RekamMedis::findOrFail($id);

        $data = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal'  => 'required|date',
            'keluhan'  => 'required|string',
            'tindakan' => 'required|string',
            'obat_id'  => 'nullable|exists:obats,id',
            'user_id'  => 'required|exists:users,id',
            'status'   => 'required|string',
        ]);

        $rekam_medis->update($data);

        logAktivitas("Mengedit rekam medis siswa {$rekam_medis->siswa->nama} pada tanggal {$rekam_medis->tanggal}", 'rekam_medis');

        return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $rekam_medis = RekamMedis::findOrFail($id);
        $nama        = $rekam_medis->siswa->nama;
        $tanggal     = $rekam_medis->tanggal;

        $rekam_medis->delete();

        logAktivitas("Menghapus rekam medis siswa {$nama} tanggal {$tanggal}", 'rekam_medis');

        return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil dihapus');
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