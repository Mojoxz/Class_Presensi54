<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'student'])->default('student')->after('password');
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('cascade')->after('role');
            $table->string('nis')->nullable()->unique()->after('kelas_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn(['role', 'kelas_id', 'nis']);
        });
    }
};
