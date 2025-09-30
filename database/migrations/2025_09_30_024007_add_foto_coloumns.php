<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->string('foto_masuk')->nullable()->after('jam_masuk');
            $table->string('foto_keluar')->nullable()->after('jam_keluar');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('foto_profil')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->dropColumn(['foto_masuk', 'foto_keluar']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('foto_profil');
        });
    }
};
