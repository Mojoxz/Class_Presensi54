<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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

        // Statistik presensi bulan ini
        $statistik = [
            'hadir' => $presensiRiwayat->where('status', 'hadir')->count(),
            'izin' => $presensiRiwayat->where('status', 'izin')->count(),
            'sakit' => $presensiRiwayat->where('status', 'sakit')->count(),
            'tidak_hadir' => $presensiRiwayat->where('status', 'tidak_hadir')->count(),
        ];

        return view('student.presensi', compact(
            'presensiHariIni',
            'presensiRiwayat',
            'bolehMasuk',
            'bolehKeluar',
            'statistik'
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
                'message' => 'Anda sudah melakukan presensi hari ini'
            ], 400);
        }

        // Validasi foto base64
        $request->validate([
            'foto_masuk' => 'required|string'
        ]);

        // Simpan foto dengan watermark
        $fotoPath = $this->saveBase64ImageWithWatermark($request->foto_masuk, 'presensi/masuk');

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

        // Simpan foto dengan watermark
        $fotoPath = $this->saveBase64ImageWithWatermark($request->foto_keluar, 'presensi/keluar');

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

    public function izin(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        // Cek apakah sudah ada presensi hari ini
        $existingPresensi = Presensi::getPresensiToday($user->id);

        if ($existingPresensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan presensi untuk hari ini'
            ], 400);
        }

        // Validasi input
        $request->validate([
            'alasan' => 'required|string|min:10|max:500',
            'foto_bukti' => 'required|string'
        ]);

        // Simpan foto bukti dengan watermark
        $fotoPath = $this->saveBase64ImageWithWatermark($request->foto_bukti, 'presensi/izin');

        if (!$fotoPath) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan foto bukti'
            ], 500);
        }

        Presensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'status' => 'izin',
            'alasan' => $request->alasan,
            'foto_bukti' => $fotoPath,
            'keterangan' => 'Izin - ' . Str::limit($request->alasan, 50)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan izin berhasil dikirim dan menunggu persetujuan admin',
        ]);
    }

    public function sakit(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        // Cek apakah sudah ada presensi hari ini
        $existingPresensi = Presensi::getPresensiToday($user->id);

        if ($existingPresensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan presensi untuk hari ini'
            ], 400);
        }

        // Validasi input
        $request->validate([
            'alasan' => 'required|string|min:10|max:500',
            'foto_bukti' => 'required|string'
        ]);

        // Simpan foto bukti surat sakit dengan watermark
        $fotoPath = $this->saveBase64ImageWithWatermark($request->foto_bukti, 'presensi/sakit');

        if (!$fotoPath) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan foto surat sakit'
            ], 500);
        }

        Presensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'status' => 'sakit',
            'alasan' => $request->alasan,
            'foto_bukti' => $fotoPath,
            'keterangan' => 'Sakit - ' . Str::limit($request->alasan, 50)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan sakit berhasil dikirim dan menunggu persetujuan admin',
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

    /**
     * Helper function untuk menyimpan gambar base64 dengan watermark
     */
    private function saveBase64ImageWithWatermark($base64String, $path)
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
            $imageData = base64_decode($base64String);

            if ($imageData === false) {
                return false;
            }

            // Generate nama file unik
            $fileName = Str::random(40) . '.jpg';
            $filePath = $path . '/' . $fileName;

            // Buat temporary file
            $tempPath = storage_path('app/temp/' . $fileName);

            // Pastikan direktori temp ada
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            file_put_contents($tempPath, $imageData);

            // Gunakan GD Library untuk watermark (alternatif jika Intervention Image tidak tersedia)
            $image = imagecreatefromstring($imageData);

            if ($image !== false) {
                $width = imagesx($image);
                $height = imagesy($image);

                // Watermark text
                $watermarkText = Carbon::now()->format('d/m/Y H:i:s');
                $userName = auth()->user()->name;

                // Warna watermark (putih dengan transparansi)
                $textColor = imagecolorallocatealpha($image, 255, 255, 255, 30);
                $bgColor = imagecolorallocatealpha($image, 0, 0, 0, 70);

                // Font size dan posisi
                $fontSize = 4; // GD font size (1-5)
                $padding = 10;
                $textWidth = imagefontwidth($fontSize) * strlen($watermarkText);
                $textHeight = imagefontheight($fontSize);

                // Background untuk watermark
                imagefilledrectangle(
                    $image,
                    $padding,
                    $height - $textHeight - ($padding * 3),
                    $textWidth + ($padding * 2),
                    $height - $padding,
                    $bgColor
                );

                // Tambahkan tanggal
                imagestring(
                    $image,
                    $fontSize,
                    $padding * 2,
                    $height - $textHeight - ($padding * 2),
                    $watermarkText,
                    $textColor
                );

                // Tambahkan nama user di bawah tanggal
                imagestring(
                    $image,
                    $fontSize,
                    $padding * 2,
                    $height - ($padding * 2) + 2,
                    $userName,
                    $textColor
                );

                // Simpan gambar dengan watermark
                ob_start();
                imagejpeg($image, null, 85);
                $imageWithWatermark = ob_get_clean();
                imagedestroy($image);

                // Simpan ke storage
                Storage::disk('public')->put($filePath, $imageWithWatermark);

                // Hapus temporary file
                @unlink($tempPath);

                return $filePath;
            }

            // Fallback: simpan tanpa watermark jika gagal
            Storage::disk('public')->put($filePath, $imageData);
            @unlink($tempPath);

            return $filePath;

        } catch (\Exception $e) {
            \Log::error('Error saving image with watermark: ' . $e->getMessage());
            return false;
        }
    }
}
