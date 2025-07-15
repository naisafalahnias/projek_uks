<?php

namespace App\Exports;

use App\Models\RekamMedis;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekamMedisExport implements FromCollection, WithHeadings
{
    /**
     * Ambil data yang mau diexport ke Excel
     */
    public function collection()
    {
        return RekamMedis::with('siswa.kelas')->get()->map(function ($item) {
            return [
                'Nama Siswa' => $item->siswa->nama,
                'Kelas'      => $item->siswa->kelas->nama_kelas ?? '-',
                'Tanggal'    => $item->tanggal,
                'Keluhan'    => $item->keluhan,
                'Status'     => $item->status,
            ];
        });
    }

    /**
     * Judul kolom di Excel
     */
    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Tanggal',
            'Keluhan',
            'Status',
        ];
    }
}
