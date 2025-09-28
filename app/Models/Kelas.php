<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'jumlah_siswa',
        'wali_kelas',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function siswa()
    {
        return $this->hasMany(User::class)->where('role', 'student');
    }

    public function updateJumlahSiswa()
    {
        $this->jumlah_siswa = $this->siswa()->count();
        $this->save();
    }
}
