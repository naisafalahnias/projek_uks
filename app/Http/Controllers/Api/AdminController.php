    <?php
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Models\Siswa;
    use App\Models\User;
    use App\Models\Obat;
    use App\Models\RekamMedis;
    use App\Models\Kelas;
    use App\Mail\HasilRekamMedis;
    use App\Models\JadwalPemeriksaan;

    class AdminController extends Controller
    {
        public function index()
        {
            $jumlahSiswa      = Siswa::count();
            $jumlahPetugas    = User::where('role', 'petugas')->count();
            $jumlahObat       = Obat::count();
            $jumlahRekamMedis = RekamMedis::count();

            $kunjunganPerBulan = RekamMedis::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
                ->whereYear('tanggal', Carbon::now()->year)
                ->groupBy(DB::raw('MONTH(tanggal)'))
                ->orderBy(DB::raw('MONTH(tanggal)'))
                ->pluck('total', 'bulan')
                ->toArray();

            $dataKunjungan = [];
            for ($i = 1; $i <= 12; $i++) {
                $dataKunjungan[] = $kunjunganPerBulan[$i] ?? 0;
            }

            $obat           = Obat::select('nama_obat', 'stok')->get();
            $dataObatLabels = $obat->pluck('nama_obat');
            $dataObatStok   = $obat->pluck('stok');
            $stokObatChart  = $obat;

            return view('dashboard.admin', compact(
                'jumlahSiswa', 'jumlahPetugas', 'jumlahObat', 'jumlahRekamMedis',
                'dataKunjungan', 'dataObatLabels', 'dataObatStok', 'stokObatChart'
            ));
        }

        // DASHBOARD STATS
        public function getStats()
        {
            return response()->json([
                'success' => true,
                'data'    => [
                    'total_rekam_medis' => RekamMedis::count(),
                    'total_siswa'       => Siswa::count(),
                    'total_obat'        => Obat::count(),
                ]
            ]);
        }

        // REKAM MEDIS
        public function getRekamMedis()
        {
            $data = RekamMedis::with('siswa.kelas')->get();
            return response()->json(['success' => true, 'data' => $data]);
        }

        public function store(Request $request)
        {
            try {
                $request->validate([
                    'siswa_id' => 'required|exists:siswas,id',
                    'keluhan'  => 'required',
                    'tindakan' => 'required',
                    'tanggal'  => 'required|date',
                ]);

                $rekam = RekamMedis::create([
                    'siswa_id' => $request->siswa_id,
                    'keluhan'  => $request->keluhan,
                    'tindakan' => $request->tindakan,
                    'tanggal'  => $request->tanggal,
                    'user_id'  => auth()->id() ?? 1,
                    'status'   => $request->status ?? 'Selesai',
                ]);

                return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!', 'data' => $rekam], 201);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
            }
        }

        public function update(Request $request, $id)
        {
            try {
                $rekam = RekamMedis::find($id);
                if (!$rekam) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);

                $request->validate([
                    'siswa_id' => 'required|exists:siswas,id',
                    'keluhan'  => 'required',
                    'tindakan' => 'required',
                    'tanggal'  => 'required|date',
                ]);

                $rekam->update([
                    'siswa_id' => $request->siswa_id,
                    'keluhan'  => $request->keluhan,
                    'tindakan' => $request->tindakan,
                    'tanggal'  => $request->tanggal,
                    'status'   => $request->status ?? 'Selesai',
                ]);

                return response()->json(['success' => true, 'message' => 'Rekam medis berhasil diperbarui!', 'data' => $rekam->load('siswa.kelas')]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Gagal update: ' . $e->getMessage()], 500);
            }
        }

        public function destroyRekamMedis($id)
        {
            try {
                $rekam = RekamMedis::find($id);
                if (!$rekam) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
                $rekam->delete();
                return response()->json(['success' => true, 'message' => 'Rekam medis berhasil dihapus']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        // KELAS & SISWA
        public function getKelas()
        {
            return response()->json(['success' => true, 'data' => Kelas::all()]);
        }

        public function getSiswaByKelas($kelas_id)
        {
            $siswa = Siswa::with('kelas')->where('kelas_id', $kelas_id)->get();
            return response()->json(['success' => true, 'data' => $siswa]);
        }

        public function getAllSiswa()
        {
            $data = Siswa::with(['kelas:id,nama_kelas'])->get();
            return response()->json(['success' => true, 'data' => $data]);
        }

        public function storeSiswa(Request $request)
        {
            try {
                $request->validate([
                    'nama'          => 'required|string|max:255',
                    'kelas_id'      => 'required|exists:kelas,id',
                    'jenis_kelamin' => 'required|in:L,P',
                    'tanggal_lahir' => 'required|date',
                ]);

                $siswa = Siswa::create([
                    'nama'          => $request->nama,
                    'kelas_id'      => $request->kelas_id,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'user_id'       => auth()->id() ?? 1,
                ]);

                return response()->json(['success' => true, 'message' => 'Siswa berhasil ditambahkan!', 'data' => $siswa->load('kelas')], 201);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function updateSiswa(Request $request, $id)
        {
            try {
                $siswa = Siswa::find($id);
                if (!$siswa) return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan'], 404);

                $request->validate([
                    'nama'          => 'required|string|max:255',
                    'kelas_id'      => 'required|exists:kelas,id',
                    'jenis_kelamin' => 'required|in:L,P',
                    'tanggal_lahir' => 'required|date',
                ]);

                $siswa->update([
                    'nama'          => $request->nama,
                    'kelas_id'      => $request->kelas_id,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tanggal_lahir' => $request->tanggal_lahir,
                ]);

                return response()->json(['success' => true, 'message' => 'Data siswa berhasil diupdate!', 'data' => $siswa->load('kelas')]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function destroySiswa($id)
        {
            try {
                $siswa = Siswa::find($id);
                if (!$siswa) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
                $siswa->delete();
                return response()->json(['success' => true, 'message' => 'Siswa berhasil dihapus']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        // =====================================================
        // KIRIM HASIL - FLUTTER API (BARU)
        // =====================================================

        public function getDaftarAkunSiswa()
        {
            try {
                $data = User::where('role', 'siswa')
                    ->whereNotNull('siswa_id')
                    ->with(['siswa.kelas', 'siswa.rekam_medis'])
                    ->get()
                    ->map(function ($user) {
                        return [
                            'user_id'           => $user->id,
                            'email'             => $user->email,
                            'siswa_id'          => $user->siswa_id,
                            'nama'              => $user->siswa->nama ?? '-',
                            'kelas'             => $user->siswa->kelas->nama_kelas ?? '-',
                            'no_hp'             => $user->no_hp ?? '-',
                            'total_rekam_medis' => $user->siswa->rekam_medis->count() ?? 0,
                        ];
                    });

                return response()->json(['success' => true, 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function kirimHasilApi($user_id)
        {
            try {
                $userSiswa = User::where('id', $user_id)->where('role', 'siswa')->first();

                if (!$userSiswa) {
                    return response()->json(['success' => false, 'message' => 'Akun siswa tidak ditemukan'], 404);
                }

                if (!$userSiswa->email) {
                    return response()->json(['success' => false, 'message' => 'Email siswa tidak tersedia'], 422);
                }

                $rekamMedis = RekamMedis::where('siswa_id', $userSiswa->siswa_id)
                    ->orderBy('tanggal', 'desc')
                    ->get();

                if ($rekamMedis->isEmpty()) {
                    return response()->json(['success' => false, 'message' => 'Siswa ini belum memiliki riwayat rekam medis'], 422);
                }

                $siswa = $userSiswa->siswa()->with('kelas')->first();

                Mail::to($userSiswa->email)->send(new HasilRekamMedis($siswa, $rekamMedis));

                return response()->json([
                    'success' => true,
                    'message' => "Email berhasil dikirim ke {$userSiswa->email}"
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function laporanKunjungan(Request $request)
        {
            try {
                $query = RekamMedis::with('siswa.kelas');
                if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
                    $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
                }
                $data = $query->latest()->get()->map(function($r) {
                    return [
                        'id'       => $r->id,
                        'tanggal'  => $r->tanggal,
                        'nama'     => $r->siswa->nama ?? '-',
                        'kelas'    => $r->siswa->kelas->nama_kelas ?? '-',
                        'keluhan'  => $r->keluhan,
                        'tindakan' => $r->tindakan,
                        'status'   => $r->status,
                    ];
                });
                return response()->json(['success' => true, 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function laporanJadwal(Request $request)
        {
            try {
                $query = \App\Models\JadwalPemeriksaan::with(['kelas', 'user']);
                if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
                    $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
                }
                $data = $query->latest()->get()->map(function($j) {
                    return [
                        'id'         => $j->id,
                        'tanggal'    => $j->tanggal,
                        'kelas'      => $j->kelas->nama_kelas ?? '-',
                        'petugas'    => $j->user->name ?? '-',
                        'keterangan' => $j->keterangan ?? '-',
                    ];
                });
                return response()->json(['success' => true, 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function laporanGizi(Request $request)
        {
            try {
                $query = \App\Models\PemeriksaanGizi::with(['siswa', 'petugas']);
                if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
                    $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
                }
                if ($request->filled('siswa_id')) {
                    $query->where('siswa_id', $request->siswa_id);
                }
                $data = $query->latest()->get()->map(function($p) {
                    return [
                        'id'           => $p->id,
                        'tanggal'      => $p->tanggal,
                        'nama'         => $p->siswa->nama ?? '-',
                        'tinggi_badan' => $p->tinggi_badan,
                        'berat_badan'  => $p->berat_badan,
                        'bmi'          => $p->bmi,
                        'keterangan'   => $p->keterangan ?? '-',
                        'status'       => $p->status,
                    ];
                });
                return response()->json(['success' => true, 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function getJadwal()
        {
            try {
                $data = JadwalPemeriksaan::with(['kelas', 'user'])->latest()->get()->map(function($j) {
                    return [
                        'id'         => $j->id,
                        'tanggal'    => $j->tanggal,
                        'kelas_id'   => $j->kelas_id,
                        'kelas'      => $j->kelas->nama_kelas ?? '-',
                        'petugas'    => $j->user->name ?? '-',
                        'keterangan' => $j->keterangan ?? '-',
                    ];
                });
                return response()->json(['success' => true, 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function storeJadwal(Request $request)
        {
            try {
                $request->validate([
                    'tanggal'    => 'required|date',
                    'kelas_id'   => 'required|exists:kelas,id',
                    'keterangan' => 'nullable|string',
                ]);
                $jadwal = JadwalPemeriksaan::create([
                    'tanggal'    => $request->tanggal,
                    'kelas_id'   => $request->kelas_id,
                    'user_id'    => auth()->id() ?? 1,
                    'keterangan' => $request->keterangan,
                ]);
                return response()->json(['success' => true, 'message' => 'Jadwal berhasil disimpan', 'data' => $jadwal->load('kelas')], 201);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function updateJadwal(Request $request, $id)
        {
            try {
                $jadwal = JadwalPemeriksaan::find($id);
                if (!$jadwal) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
                $request->validate([
                    'tanggal'    => 'required|date',
                    'kelas_id'   => 'required|exists:kelas,id',
                    'keterangan' => 'nullable|string',
                ]);
                $jadwal->update([
                    'tanggal'    => $request->tanggal,
                    'kelas_id'   => $request->kelas_id,
                    'keterangan' => $request->keterangan,
                ]);
                return response()->json(['success' => true, 'message' => 'Jadwal berhasil diupdate', 'data' => $jadwal->load('kelas')]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function destroyJadwal($id)
        {
            try {
                $jadwal = JadwalPemeriksaan::find($id);
                if (!$jadwal) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
                $jadwal->delete();
                return response()->json(['success' => true, 'message' => 'Jadwal berhasil dihapus']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        // ===================== OBAT =====================
        public function getObat()
        {
            try {
                $data = Obat::all()->map(function($o) {
                    $today = Carbon::today();
                    $kadaluarsa = Carbon::parse($o->tgl_kadaluarsa);
                    if ($kadaluarsa->isPast()) $status = 'Kadaluarsa';
                    elseif ($kadaluarsa->diffInDays($today) <= 90) $status = 'Hampir Kadaluarsa';
                    else $status = 'Aman';
                    return [
                        'id'             => $o->id,
                        'nama_obat'      => $o->nama_obat,
                        'kategori'       => $o->kategori,
                        'stok'           => $o->stok,
                        'tgl_kadaluarsa' => $o->tgl_kadaluarsa,
                        'unit'           => $o->unit,
                        'deskripsi'      => $o->deskripsi ?? '-',
                        'status'         => $status,
                    ];
                });
                return response()->json(['success' => true, 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function storeObat(Request $request)
        {
            try {
                $request->validate([
                    'nama_obat'      => 'required',
                    'kategori'       => 'required',
                    'stok'           => 'required|numeric',
                    'tgl_kadaluarsa' => 'required|date',
                    'unit'           => 'required',
                    'deskripsi'      => 'nullable',
                ]);
                $obat = Obat::create($request->only(['nama_obat','kategori','stok','tgl_kadaluarsa','unit','deskripsi']));
                return response()->json(['success' => true, 'message' => 'Obat berhasil ditambahkan', 'data' => $obat], 201);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function updateObat(Request $request, $id)
        {
            try {
                $obat = Obat::find($id);
                if (!$obat) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
                $request->validate([
                    'nama_obat'      => 'required',
                    'kategori'       => 'required',
                    'stok'           => 'required|numeric',
                    'tgl_kadaluarsa' => 'required|date',
                    'unit'           => 'required',
                    'deskripsi'      => 'nullable',
                ]);
                $obat->update($request->only(['nama_obat','kategori','stok','tgl_kadaluarsa','unit','deskripsi']));
                return response()->json(['success' => true, 'message' => 'Obat berhasil diupdate', 'data' => $obat]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function destroyObat($id)
        {
            try {
                $obat = Obat::find($id);
                if (!$obat) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
                $obat->delete();
                return response()->json(['success' => true, 'message' => 'Obat berhasil dihapus']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function getAktivitasTerbaru()
        {
            try {
                $data = RekamMedis::with('siswa', 'user')
                    ->latest()
                    ->limit(10)
                    ->get()
                    ->map(function($r) {
                        $status = strtolower($r->status ?? '');
                        if (str_contains($status, 'pulang')) $icon = 'pulang';
                        elseif (str_contains($status, 'uks') || str_contains($status, 'istirahat')) $icon = 'uks';
                        else $icon = 'kelas';

                        return [
                            'nama'    => $r->siswa->nama ?? '-',
                            'status'  => $r->status ?? '-',
                            'waktu'   => \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y'),
                            'petugas' => $r->user->name ?? '-',
                            'icon'    => $icon,
                        ];
                    });

                return response()->json(['success' => true, 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function getLogAktivitas(Request $request)
        {
            try {
                // Ambil log milik user yang sedang login saja
                $data = \App\Models\LogAktivitas::where('user_id', auth()->id())
                    ->latest()
                    ->limit(10)
                    ->get()
                    ->map(function($log) {
                        // Tentukan icon berdasarkan kata kunci di aksi
                        $aksi = strtolower($log->aksi ?? '');
                        if (str_contains($aksi, 'tambah') || str_contains($aksi, 'menambah') || str_contains($aksi, 'simpan')) {
                            $icon = 'tambah';
                        } elseif (str_contains($aksi, 'edit') || str_contains($aksi, 'mengubah') || str_contains($aksi, 'update') || str_contains($aksi, 'perbarui')) {
                            $icon = 'edit';
                        } elseif (str_contains($aksi, 'hapus') || str_contains($aksi, 'menghapus')) {
                            $icon = 'hapus';
                        } elseif (str_contains($aksi, 'kirim') || str_contains($aksi, 'mengirim')) {
                            $icon = 'kirim';
                        } elseif (str_contains($aksi, 'cetak') || str_contains($aksi, 'export') || str_contains($aksi, 'laporan')) {
                            $icon = 'laporan';
                        } else {
                            $icon = 'info';
                        }

                        return [
                            'aksi'  => $log->aksi ?? '-',
                            'tabel' => $log->tabel ?? '-',
                            'waktu' => \Carbon\Carbon::parse($log->created_at)->diffForHumans(),
                            'icon'  => $icon,
                        ];
                    });

                return response()->json(['success' => true, 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }
    }