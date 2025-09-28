<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\Berita;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Presensi hari ini
        $presensiHariIni = Presensi::getPresensiToday($user->id);

        // Statistik presensi bulan ini
        $statistikBulanIni = Presensi::getStatistik($user->id, Carbon::now()->month, Carbon::now()->year);

        // Presensi 7 hari terakhir
        $presensi7Hari = Presensi::where('user_id', $user->id)
                                 ->where('tanggal', '>=', Carbon::now()->subDays(7))
                                 ->orderBy('tanggal', 'desc')
                                 ->get();

        return view('student.dashboard', compact(
            'presensiHariIni',
            'statistikBulanIni',
            'presensi7Hari'
        ));
    }

    public function home()
    {
        $berita = Berita::where('is_published', true)
                       ->latest()
                       ->take(5)
                       ->get();

        return view('student.home', compact('berita'));
    }
}
