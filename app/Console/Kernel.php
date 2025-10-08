<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jalankan setiap hari pada pukul 00:01 (tepat setelah tengah malam)
        // Ini akan mengecek presensi hari sebelumnya
        $schedule->command('presensi:update-tidak-hadir')
                 ->dailyAt('00:01')
                 ->withoutOverlapping()
                 ->onOneServer()
                 ->runInBackground();

        // ALTERNATIF: Jalankan setiap hari pada pukul 23:59 (sebelum tengah malam)
        // Ini akan mengecek presensi hari ini sebelum hari berganti
        $schedule->command('presensi:update-tidak-hadir-today')
                 ->dailyAt('23:59')
                 ->withoutOverlapping()
                 ->onOneServer()
                 ->runInBackground();

        // ALTERNATIF 2: Jalankan setiap jam untuk testing
        // $schedule->command('presensi:update-tidak-hadir')
        //          ->hourly()
        //          ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
