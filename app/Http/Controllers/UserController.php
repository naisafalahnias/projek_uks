<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\RekamMedis;
use App\Mail\HasilRekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        $data = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'role'     => 'required|in:admin,petugas',
            'no_hp'    => 'required|string|max:15',
            'password' => 'required|min:6',
        ]);

        $data['password'] = Hash::make($request->password);
        User::create($data);

        return redirect()->route('backend.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function destroy($id)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa hapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }

    /* ======================
       AKUN SISWA
    ====================== */

    public function siswaIndex()
    {
        $users = User::where('role', 'siswa')->with('siswa.kelas')->get();
        return view('backend.akun_siswa.index', compact('users'));
    }

    public function siswaCreate()
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $data_siswa = Siswa::whereDoesntHave('akun')->orderBy('nama', 'asc')->get();
        return view('backend.akun_siswa.create', compact('data_siswa'));
    }

    public function siswaStore(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $data = $request->validate([
            'siswa_id' => 'required|exists:siswas,id|unique:users,siswa_id',
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'no_hp'    => 'required|string|max:15',
            'password' => 'required|min:6',
        ]);

        $data['role']     = 'siswa';
        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()->route('backend.akun_siswa.index')->with('success', 'Akun siswa berhasil dibuat');
    }

    /* ======================
       FITUR KIRIM HASIL
    ====================== */

    public function kirimHasil($id)
    {
        // Hanya admin dan petugas yang boleh
        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            abort(403, 'Anda tidak memiliki akses untuk fitur ini.');
        }

        $userSiswa = User::where('id', $id)
            ->where('role', 'siswa')
            ->firstOrFail();

        // Ambil SEMUA rekam medis siswa, urutkan terbaru dulu
        $rekamMedis = RekamMedis::where('siswa_id', $userSiswa->siswa_id)
            ->orderBy('tanggal', 'desc')
            ->get();

        if ($rekamMedis->isEmpty()) {
            return back()->with('error', 'Siswa ini belum memiliki riwayat rekam medis.');
        }

        $siswa = $userSiswa->siswa()->with('kelas')->first();

        // Kirim email
        Mail::to($userSiswa->email)->send(new HasilRekamMedis($siswa, $rekamMedis));

        return back()->with('success', 'Hasil rekam medis berhasil dikirim ke: ' . $userSiswa->email);
    }
}