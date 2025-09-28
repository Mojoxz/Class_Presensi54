<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kelas;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Kelas
        $kelasData = [
            ['nama_kelas' => '8A', 'wali_kelas' => 'Budi Santoso, S.Pd'],
            ['nama_kelas' => '8B', 'wali_kelas' => 'Siti Aminah, S.Pd'],
            ['nama_kelas' => '8C', 'wali_kelas' => 'Ahmad Fauzi, S.Pd'],
            ['nama_kelas' => '8D', 'wali_kelas' => 'Ratna Sari, S.Pd'],
            ['nama_kelas' => '8E', 'wali_kelas' => 'Joko Widodo, S.Pd'],
            ['nama_kelas' => '8F', 'wali_kelas' => 'Maya Sari, S.Pd'],
            ['nama_kelas' => '8G', 'wali_kelas' => 'Andi Prasetyo, S.Pd'],
            ['nama_kelas' => '8H', 'wali_kelas' => 'Dewi Lestari, S.Pd'],
            ['nama_kelas' => '8I', 'wali_kelas' => 'Bambang Sutrisno, S.Pd'],
        ];

        foreach ($kelasData as $kelas) {
            Kelas::create($kelas);
        }

        // Create Admin User
        User::create([
            'name' => 'Admin SMP 54',
            'email' => 'admin@smp54.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Sample Student
        User::create([
            'name' => 'John Doe',
            'email' => 'john@student.smp54.sch.id',
            'password' => Hash::make('student123'),
            'role' => 'student',
            'kelas_id' => 1,
            'nis' => '2024001',
        ]);
    }
}
