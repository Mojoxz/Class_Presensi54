<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PresensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $bulan;
    protected $tahun;
    protected $kelasId;

    public function __construct($bulan, $tahun, $kelasId = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->kelasId = $kelasId;
    }

    public function collection()
    {
        $query = User::where('role', 'student')
                    ->with(['kelas', 'presensi' => function($q) {
                        $q->whereMonth('tanggal', $this->bulan)
                          ->whereYear('tanggal', $this->tahun);
                    }]);

        if ($this->kelasId) {
            $query->where('kelas_id', $this->kelasId);
        }

        return $query->get();
    }

    public function map($siswa): array
    {
        $presensi = $siswa->presensi;
        $total = $presensi->count();
        $hadir = $presensi->where('status', 'hadir')->count();
        $tidakHadir = $presensi->where('status', 'tidak_hadir')->count();
        $izin = $presensi->where('status', 'izin')->count();
        $sakit = $presensi->where('status', 'sakit')->count();
        $persentase = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

        return [
            $siswa->nis,
            $siswa->name,
            $siswa->kelas->nama_kelas ?? '-',
            $total,
            $hadir,
            $izin,
            $sakit,
            $tidakHadir,
            $persentase . '%'
        ];
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Total Presensi',
            'Hadir',
            'Izin',
            'Sakit',
            'Tidak Hadir',
            'Persentase Kehadiran'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        $bulanText = \Carbon\Carbon::create()->month($this->bulan)->format('F');
        return "Rekap {$bulanText} {$this->tahun}";
    }
}
