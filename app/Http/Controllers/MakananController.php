<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $makanans = Makanan::latest()->get();
        return view('backend.makanans.index', compact('makanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.makanans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'jenis' => 'required|in:snack,minuman,berat',
            'kalori' => 'required|integer',
            'gula' => 'required|numeric',
            'status' => 'required|in:sehat,tidak_sehat',
        ]);

        Makanan::create($request->all());

        return redirect()
            ->route('backend.makanans.index')
            ->with('success', 'Data makanan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $makanan = Makanan::findOrFail($id);
        return view('backend.makanans.edit', compact('makanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'jenis' => 'required|in:snack,minuman,berat',
            'kalori' => 'required|integer',
            'gula' => 'required|numeric',
            'status' => 'required|in:sehat,tidak_sehat',
        ]);

        $makanan = Makanan::findOrFail($id);
        $makanan->update($request->all());

        return redirect()
            ->route('backend.makanans.index')
            ->with('success', 'Data makanan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $makanan = Makanan::findOrFail($id);
        $makanan->delete();

        return redirect()
            ->route('backend.makanans.index')
            ->with('success', 'Data makanan berhasil dihapus');
    }
}
