<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Presensi;
use Carbon\Carbon;

class UpdateStatusTidakHadir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:update-tidak-hadir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status siswa yang tidak melakukan presensi menjadi tidak_hadir';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses update status tidak hadir...');

        // Ambil tanggal kemarin (24 jam yang lalu)
        $tanggalKemarin = Carbon::yesterday()->format('Y-m-d');

        $this->info("Mengecek presensi untuk tanggal: {$tanggalKemarin}");

        // Ambil semua siswa yang aktif
        $siswaList = User::where('role', 'student')
                        ->where('is_active', true) // Opsional: jika ada kolom is_active
                        ->get();

        $totalSiswa = $siswaList->count();
        $tidakHadirCount = 0;

        $this->info("Total siswa aktif: {$totalSiswa}");

        foreach ($siswaList as $siswa) {
            // Cek apakah siswa sudah ada presensi untuk tanggal kemarin
            $presensi = Presensi::where('user_id', $siswa->id)
                               ->where('tanggal', $tanggalKemarin)
                               ->first();

            // Jika tidak ada presensi sama sekali, buat record dengan status tidak_hadir
            if (!$presensi) {
                Presensi::create([
                    'user_id' => $siswa->id,
                    'tanggal' => $tanggalKemarin,
                    'status' => 'tidak_hadir',
                    'keterangan' => 'Tidak melakukan presensi (Auto-generated)',
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                    'foto_masuk' => null,
                    'foto_keluar' => null,
                ]);

                $tidakHadirCount++;
                $this->line("✓ {$siswa->name} ({$siswa->nim}) - Status: TIDAK HADIR (dibuat otomatis)");
            } else {
                // Jika ada presensi, cek statusnya
                $this->line("- {$siswa->name} ({$siswa->nim}) - Status: {$presensi->status}");
            }
        }

        $this->newLine();
        $this->info("=== SUMMARY ===");
        $this->info("Total siswa dicek: {$totalSiswa}");
        $this->info("Siswa tidak hadir (otomatis): {$tidakHadirCount}");
        $this->info("Proses selesai!");

        return Command::SUCCESS;
    }
}
