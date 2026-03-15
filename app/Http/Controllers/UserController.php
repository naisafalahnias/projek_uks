<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\RekamMedis;

class UserController extends Controller
{
    /* ======================
       USER ADMIN & PETUGAS
    ====================== */

    public function index()
    {
        $users = User::whereIn('role', ['admin', 'petugas'])->get();
        return view('backend.user.index', compact('users'));
    }

    public function create()
    {
        abort_if(Auth::user()->role !== 'admin', 403);
        return view('backend.user.create');
    }

    public function store(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,petugas',
            'no_hp' => 'required|string|max:15',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('backend.user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function destroy($id)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        User::destroy($id);
        return back()->with('success', 'User dihapus');
    }

    /* ======================
       AKUN SISWA
    ====================== */

    // ADMIN + PETUGAS (lihat data)
    public function siswaIndex()
    {
        $users = User::where('role', 'siswa')->get();
        return view('backend.akun_siswa.index', compact('users'));
    }

    /* ======================
    AKUN SISWA
    ====================== */

    // ADMIN ONLY - Tampilkan Form Create
    public function siswaCreate()
    {
        abort_if(Auth::user()->role !== 'admin', 403);
        
        // AMBIL DATA SISWA: Untuk dropdown di view
        // Kita ambil yang belum punya akun (opsional) atau semua siswa
        $data_siswa = \App\Models\Siswa::orderBy('nama', 'asc')->get();
        
        return view('backend.akun_siswa.create', compact('data_siswa'));
    }

    // ADMIN ONLY - Simpan ke Database
    public function siswaStore(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id', // Pastikan ID siswa valid
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'no_hp'    => 'required|string|max:15',
            'password' => 'required|min:6',
        ]);

        User::create([
            'siswa_id' => $request->siswa_id, // KABEL PENGHUBUNG
            'name'     => $request->name,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'role'     => 'siswa',
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('backend.akun_siswa.index')
            ->with('success', 'Akun siswa berhasil dihubungkan dan ditambahkan');
    }

    public function siswaDestroy($id)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        User::where('id', $id)
            ->where('role', 'siswa')
            ->delete();

        return back()->with('success', 'Akun siswa dihapus');
    }

    /* ======================
       FITUR PETUGAS
    ====================== */

    // PETUGAS: kirim hasil ke siswa
    public function kirimHasil($id)
    {
        abort_if(Auth::user()->role !== 'petugas', 403);

        $siswa = User::where('id', $id)
            ->where('role', 'siswa')
            ->firstOrFail();

        $rekamMedis = RekamMedis::where('siswa_id', $id)
            ->latest()
            ->first();

        // NANTI: generate PDF + kirim email
        // Mail::to($siswa->email)->send(new RekamMedisMail($pdf));

        return back()->with('success', 'Hasil berhasil dikirim ke email siswa');
    }

    
}
