<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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

        // Cek jam operasional
        $jamSekarang = Carbon::now();
        $jamBukaMasuk = Carbon::today()->setTime(6, 0, 0); // 06:00
        $jamTutupMasuk = Carbon::today()->setTime(8, 30, 0); // 08:30
        $jamBukaKeluar = Carbon::today()->setTime(14, 0, 0); // 14:00
        $jamTutupKeluar = Carbon::today()->setTime(18, 0, 0); // 18:00

        $bolehMasuk = $jamSekarang->between($jamBukaMasuk, $jamTutupMasuk);
        $bolehKeluar = $jamSekarang->between($jamBukaKeluar, $jamTutupKeluar);

        return view('student.presensi', compact(
            'presensiHariIni',
            'presensiRiwayat',
            'bolehMasuk',
            'bolehKeluar'
        ));
    }

    public function masuk(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();
        $jamSekarang = Carbon::now();

        // Validasi jam operasional
        $jamBukaMasuk = Carbon::today()->setTime(6, 0, 0);
        $jamTutupMasuk = Carbon::today()->setTime(8, 30, 0);

        if (!$jamSekarang->between($jamBukaMasuk, $jamTutupMasuk)) {
            return redirect()->back()->with('error', 'Presensi masuk hanya bisa dilakukan antara jam 06:00 - 08:30');
        }

        // Cek apakah sudah presensi hari ini
        $existingPresensi = Presensi::getPresensiToday($user->id);

        if ($existingPresensi) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi masuk hari ini');
        }

        // Validasi foto
        $request->validate([
            'foto_masuk' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Upload foto
        $fotoPath = null;
        if ($request->hasFile('foto_masuk')) {
            $fotoPath = $request->file('foto_masuk')->store('presensi/masuk', 'public');
        }

        // Cek keterlambatan
        $batasJamMasuk = Carbon::today()->setTime(7, 30, 0); // Batas tepat waktu jam 07:30
        $status = 'hadir';
        $keterangan = null;

        if ($jamSekarang->isAfter($batasJamMasuk)) {
            $keterangan = 'Terlambat ' . $batasJamMasuk->diffInMinutes($jamSekarang) . ' menit';
        }

        Presensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'jam_masuk' => $jamSekarang,
            'foto_masuk' => $fotoPath,
            'status' => $status,
            'keterangan' => $keterangan,
        ]);

        return redirect()->back()->with('success', 'Presensi masuk berhasil dicatat pada ' . $jamSekarang->format('H:i:s'));
    }

    public function keluar(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();
        $jamSekarang = Carbon::now();

        // Validasi jam operasional
        $jamBukaKeluar = Carbon::today()->setTime(14, 0, 0);
        $jamTutupKeluar = Carbon::today()->setTime(18, 0, 0);

        if (!$jamSekarang->between($jamBukaKeluar, $jamTutupKeluar)) {
            return redirect()->back()->with('error', 'Presensi keluar hanya bisa dilakukan antara jam 14:00 - 18:00');
        }

        // Cari presensi hari ini
        $presensi = Presensi::getPresensiToday($user->id);

        if (!$presensi) {
            return redirect()->back()->with('error', 'Anda belum melakukan presensi masuk');
        }

        if ($presensi->jam_keluar) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi keluar');
        }

        // Validasi foto
        $request->validate([
            'foto_keluar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Upload foto
        $fotoPath = null;
        if ($request->hasFile('foto_keluar')) {
            $fotoPath = $request->file('foto_keluar')->store('presensi/keluar', 'public');
        }

        $presensi->update([
            'jam_keluar' => $jamSekarang,
            'foto_keluar' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Presensi keluar berhasil dicatat pada ' . $jamSekarang->format('H:i:s'));
    }
}
