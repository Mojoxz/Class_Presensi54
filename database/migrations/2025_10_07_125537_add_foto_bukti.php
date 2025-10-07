<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk menambahkan kolom foto_bukti, alasan, dan approval system
     * Nama file: 2025_01_08_000001_add_izin_sakit_columns_to_presensi_table.php
     */
    public function up(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            // Kolom untuk izin/sakit
            $table->string('foto_bukti')->nullable()->after('foto_keluar');
            $table->text('alasan')->nullable()->after('keterangan');

            // Kolom untuk approval system
            $table->boolean('is_approved')->nullable()->after('alasan');
            $table->timestamp('approved_at')->nullable()->after('is_approved');
            $table->foreignId('approved_by')->nullable()->constrained('users')->after('approved_at');

            // Kolom untuk rejection
            $table->text('alasan_penolakan')->nullable()->after('approved_by');
            $table->timestamp('rejected_at')->nullable()->after('alasan_penolakan');
            $table->foreignId('rejected_by')->nullable()->constrained('users')->after('rejected_at');
        });
    }

    public function down(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropColumn([
                'foto_bukti',
                'alasan',
                'is_approved',
                'approved_at',
                'approved_by',
                'alasan_penolakan',
                'rejected_at',
                'rejected_by'
            ]);
        });
    }
};
