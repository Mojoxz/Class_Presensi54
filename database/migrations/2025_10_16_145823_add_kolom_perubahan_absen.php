<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            // Kolom untuk menyimpan status awal sebelum diubah
            $table->enum('status_awal', ['hadir', 'tidak_hadir', 'izin', 'sakit'])->nullable()->after('status');

            // Kolom untuk tracking kapan status diubah menjadi izin/sakit
            $table->timestamp('updated_to_izin_sakit_at')->nullable()->after('rejected_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->dropColumn(['status_awal', 'updated_to_izin_sakit_at']);
        });
    }
};
