<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\Berita;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = User::where('role', 'student')->count();
        $totalKelas = Kelas::count();
        $totalBerita = Berita::count();

        $presensiHariIni = Presensi::where('tanggal', Carbon::today())
                                  ->where('status', 'hadir')
                                  ->count();

        // Statistik presensi minggu ini
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();

        $presensiMingguIni = Presensi::whereBetween('tanggal', [$startWeek, $endWeek])
                                    ->selectRaw('DATE(tanggal) as tanggal, COUNT(*) as total')
                                    ->where('status', 'hadir')
                                    ->groupBy('tanggal')
                                    ->orderBy('tanggal')
                                    ->get();

        // Presensi per kelas hari ini
        $presensiPerKelas = Kelas::with(['siswa' => function($query) {
            $query->with(['presensi' => function($q) {
                $q->where('tanggal', Carbon::today());
            }]);
        }])->get()->map(function($kelas) {
            $totalSiswa = $kelas->siswa->count();
            $hadir = $kelas->siswa->filter(function($siswa) {
                return $siswa->presensi->where('status', 'hadir')->count() > 0;
            })->count();

            return [
                'nama_kelas' => $kelas->nama_kelas,
                'total_siswa' => $totalSiswa,
                'hadir' => $hadir,
                'tidak_hadir' => $totalSiswa - $hadir
            ];
        });

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalKelas',
            'totalBerita',
            'presensiHariIni',
            'presensiMingguIni',
            'presensiPerKelas'
        ));
    }
}
