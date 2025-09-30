<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            return response()->json([
                'success' => false,
                'message' => 'Presensi masuk hanya bisa dilakukan antara jam 06:00 - 08:30'
            ], 400);
        }

        // Cek apakah sudah presensi hari ini
        $existingPresensi = Presensi::getPresensiToday($user->id);

        if ($existingPresensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan presensi masuk hari ini'
            ], 400);
        }

        // Validasi foto base64
        $request->validate([
            'foto_masuk' => 'required|string'
        ]);

        // Simpan foto dari base64
        $fotoPath = $this->saveBase64Image($request->foto_masuk, 'presensi/masuk');

        if (!$fotoPath) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan foto'
            ], 500);
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

        return response()->json([
            'success' => true,
            'message' => 'Presensi masuk berhasil dicatat pada ' . $jamSekarang->format('H:i:s'),
            'data' => [
                'jam_masuk' => $jamSekarang->format('H:i:s'),
                'keterangan' => $keterangan
            ]
        ]);
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
            return response()->json([
                'success' => false,
                'message' => 'Presensi keluar hanya bisa dilakukan antara jam 14:00 - 18:00'
            ], 400);
        }

        // Cari presensi hari ini
        $presensi = Presensi::getPresensiToday($user->id);

        if (!$presensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan presensi masuk'
            ], 400);
        }

        if ($presensi->jam_keluar) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan presensi keluar'
            ], 400);
        }

        // Validasi foto base64
        $request->validate([
            'foto_keluar' => 'required|string'
        ]);

        // Simpan foto dari base64
        $fotoPath = $this->saveBase64Image($request->foto_keluar, 'presensi/keluar');

        if (!$fotoPath) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan foto'
            ], 500);
        }

        $presensi->update([
            'jam_keluar' => $jamSekarang,
            'foto_keluar' => $fotoPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Presensi keluar berhasil dicatat pada ' . $jamSekarang->format('H:i:s'),
            'data' => [
                'jam_keluar' => $jamSekarang->format('H:i:s')
            ]
        ]);
    }

    /**
     * Helper function untuk menyimpan gambar base64
     */
    private function saveBase64Image($base64String, $path)
    {
        try {
            // Hapus prefix data:image/...;base64, jika ada
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif
            } else {
                return false;
            }

            // Decode base64
            $image = base64_decode($base64String);

            if ($image === false) {
                return false;
            }

            // Generate nama file unik
            $fileName = Str::random(40) . '.' . $type;
            $filePath = $path . '/' . $fileName;

            // Simpan file
            Storage::disk('public')->put($filePath, $image);

            return $filePath;
        } catch (\Exception $e) {
            \Log::error('Error saving image: ' . $e->getMessage());
            return false;
        }
    }
}
