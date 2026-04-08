<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::all()->map(function ($item) {
            $today = Carbon::today();
            $kadaluarsa = Carbon::parse($item->tgl_kadaluarsa);

            if ($kadaluarsa->isPast()) {
                $item->status_kadaluarsa = 'expired';
            } elseif ($kadaluarsa->diffInDays($today) <= 30) {
                $item->status_kadaluarsa = 'near_expired';
            } else {
                $item->status_kadaluarsa = 'safe';
            }
            return $item;
        });

        return view('backend.obat.index', compact('obat'));
    }

    public function create()
    {
        return view('backend.obat.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_obat'      => 'required',
            'kategori'       => 'required',
            'stok'           => 'required|numeric',
            'tgl_kadaluarsa' => 'required|date',
            'unit'           => 'required',
            'deskripsi'      => 'nullable',
        ]);

        // Observer otomatis mencatat: "Menambah Obat [Nama]"
        Obat::create($data);

        return redirect()->route('backend.obat.index')->with('success', 'Obat berhasil ditambahkan');
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id);
        return view('backend.obat.show', compact('obat'));
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('backend.obat.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_obat'      => 'required',
            'kategori'       => 'required',
            'stok'           => 'required|numeric',
            'tgl_kadaluarsa' => 'required|date',
            'unit'           => 'required',
            'deskripsi'      => 'nullable',
        ]);

        $obat = Obat::findOrFail($id);
        
        // Observer otomatis mencatat perubahan (termasuk jika stok berubah)
        $obat->update($data);

        return redirect()->route('backend.obat.index')->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        
        // Observer otomatis mencatat sebelum data dihapus
        $obat->delete();

        return redirect()->route('backend.obat.index')->with('success', 'Data Berhasil Dihapus');
    }
}
