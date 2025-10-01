<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MuridExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $murid;

    public function __construct($murid)
    {
        $this->murid = $murid;
    }

    /**
     * Return collection of data
     */
    public function collection()
    {
        return $this->murid;
    }

    /**
     * Define column headings
     */
    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Lengkap',
            'Email',
            'Kelas',
            'Status Akun',
            'Tanggal Bergabung',
            'Total Hadir',
            'Total Izin',
            'Total Sakit',
            'Total Tidak Hadir',
        ];
    }

    /**
     * Map data for each row
     */
    public function map($murid): array
    {
        static $no = 0;
        $no++;

        // Hitung statistik presensi
        $totalHadir = $murid->presensi()->where('status', 'hadir')->count();
        $totalIzin = $murid->presensi()->where('status', 'izin')->count();
        $totalSakit = $murid->presensi()->where('status', 'sakit')->count();
        $totalTidakHadir = $murid->presensi()->where('status', 'tidak_hadir')->count();

        return [
            $no,
            $murid->nis,
            $murid->name,
            $murid->email,
            $murid->kelas->nama_kelas ?? '-',
            'Aktif',
            $murid->created_at->format('d/m/Y'),
            $totalHadir,
            $totalIzin,
            $totalSakit,
            $totalTidakHadir,
        ];
    }

    /**
     * Style the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
