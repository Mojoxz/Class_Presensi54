<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MuridImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Cari kelas berdasarkan nama
        $kelas = Kelas::where('nama_kelas', $row['kelas'])->first();

        if (!$kelas) {
            throw new \Exception('Kelas ' . $row['kelas'] . ' tidak ditemukan');
        }

        $user = User::create([
            'name' => $row['nama'],
            'email' => $row['email'],
            'nis' => $row['nis'],
            'password' => Hash::make($row['password'] ?? 'default123'),
            'role' => 'student',
            'kelas_id' => $kelas->id,
        ]);

        // Update jumlah siswa
        $kelas->updateJumlahSiswa();

        return $user;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|string|unique:users,nis',
            'kelas' => 'required|string',
        ];
    }
}
