<?php
// File ini seharusnya DIHAPUS karena tabel sessions sudah dibuat di 0001_01_01_000000_create_users_table.php
//
// HAPUS FILE: database/migrations/2025_09_27_165219_create_sessions_table.php
//
// Jika Anda tetap ingin mempertahankan file ini, ubah isinya menjadi:

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
        // Tidak melakukan apa-apa karena tabel sessions sudah dibuat sebelumnya
        // Atau bisa menambahkan kolom baru jika diperlukan
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak melakukan apa-apa karena tabel sessions akan dihapus oleh migration utama
    }
};
