<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Presensi;
use Carbon\Carbon;

class UpdateStatusTidakHadirToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:update-tidak-hadir-today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status siswa yang tidak melakukan presensi hari ini menjadi tidak_hadir (sebelum tengah malam)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses update status tidak hadir untuk HARI INI...');

        // Ambil tanggal hari ini
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        // Cek apakah sudah melewati jam tutup presensi (misal 08:30)
        $jamSekarang = Carbon::now();
        $jamTutupPresensi = Carbon::today()->setTime(8, 30, 0);

        if ($jamSekarang->lessThan($jamTutupPresensi)) {
            $this->warn('Belum melewati jam tutup presensi (08:30). Command dibatalkan.');
            return Command::FAILURE;
        }

        $this->info("Mengecek presensi untuk tanggal: {$tanggalHariIni}");

        // Ambil semua siswa yang aktif
        $siswaList = User::where('role', 'student')
                        ->where('is_active', true) // Opsional
                        ->get();

        $totalSiswa = $siswaList->count();
        $tidakHadirCount = 0;
        $sudahPresensiCount = 0;

        $this->info("Total siswa aktif: {$totalSiswa}");

        foreach ($siswaList as $siswa) {
            // Cek apakah siswa sudah ada presensi untuk hari ini
            $presensi = Presensi::where('user_id', $siswa->id)
                               ->where('tanggal', $tanggalHariIni)
                               ->first();

            // Jika tidak ada presensi sama sekali, buat record dengan status tidak_hadir
            if (!$presensi) {
                Presensi::create([
                    'user_id' => $siswa->id,
                    'tanggal' => $tanggalHariIni,
                    'status' => 'tidak_hadir',
                    'keterangan' => 'Tidak melakukan presensi masuk (Auto-generated)',
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                    'foto_masuk' => null,
                    'foto_keluar' => null,
                ]);

                $tidakHadirCount++;
                $this->line("✓ {$siswa->name} ({$siswa->nis}) - Status: TIDAK HADIR (dibuat otomatis)");
            } else {
                // Jika ada presensi, tampilkan statusnya
                $statusDisplay = ucfirst(str_replace('_', ' ', $presensi->status));

                // Tampilkan info approval status untuk izin/sakit
                if (in_array($presensi->status, ['izin', 'sakit'])) {
                    $approvalInfo = '';
                    if ($presensi->is_approved === true) {
                        $approvalInfo = ' (Disetujui)';
                    } elseif ($presensi->is_approved === false) {
                        $approvalInfo = ' (Ditolak)';
                    } else {
                        $approvalInfo = ' (Pending)';
                    }
                    $statusDisplay .= $approvalInfo;
                }

                $this->line("- {$siswa->name} ({$siswa->nis}) - Status: {$statusDisplay}");
                $sudahPresensiCount++;
            }
        }

        $this->newLine();
        $this->info("=== SUMMARY ===");
        $this->info("Total siswa dicek: {$totalSiswa}");
        $this->info("Siswa sudah presensi: {$sudahPresensiCount}");
        $this->info("Siswa tidak hadir (otomatis): {$tidakHadirCount}");
        $this->info("Proses selesai!");

        return Command::SUCCESS;
    }
}
