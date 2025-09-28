<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();

        // Cek presensi hari ini
        $presensiHariIni = Presensi::getPresensiToday($user->id);

        // Riwayat presensi bulan ini
        $presensiRiwayat = Presensi::where('user_id', $user->id)
                                  ->whereMonth('tanggal', Carbon::now()->month)
                                  ->whereYear('tanggal', Carbon::now()->year)
                                  ->orderBy('tanggal', 'desc')
                                  ->get();

        return view('student.presensi', compact('presensiHariIni', 'presensiRiwayat'));
    }

    public function masuk(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        // Cek apakah sudah presensi hari ini
        $existingPresensi = Presensi::getPresensiToday($user->id);

        if ($existingPresensi) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi masuk hari ini');
        }

        // Cek jam masuk (misalnya harus sebelum jam 8:00)
        $jamSekarang = Carbon::now();
        $batasJamMasuk = Carbon::today()->setTime(8, 0, 0);

        $status = 'hadir';
        $keterangan = null;

        if ($jamSekarang->isAfter($batasJamMasuk)) {
            $keterangan = 'Terlambat';
        }

        Presensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'jam_masuk' => $jamSekarang,
            'status' => $status,
            'keterangan' => $keterangan,
        ]);

        return redirect()->back()->with('success', 'Presensi masuk berhasil dicatat');
    }

    public function keluar(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        // Cari presensi hari ini
        $presensi = Presensi::getPresensiToday($user->id);

        if (!$presensi) {
            return redirect()->back()->with('error', 'Anda belum melakukan presensi masuk');
        }

        if ($presensi->jam_keluar) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi keluar');
        }

        $presensi->update([
            'jam_keluar' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Presensi keluar berhasil dicatat');
    }
}
