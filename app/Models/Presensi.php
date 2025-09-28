<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i:s',
        'jam_keluar' => 'datetime:H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getPresensiToday($userId)
    {
        return self::where('user_id', $userId)
                   ->where('tanggal', Carbon::today())
                   ->first();
    }

    public static function getStatistik($userId, $bulan = null, $tahun = null)
    {
        $query = self::where('user_id', $userId);

        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }

        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        $total = $query->count();
        $hadir = $query->where('status', 'hadir')->count();
        $tidak_hadir = $query->where('status', 'tidak_hadir')->count();
        $izin = $query->where('status', 'izin')->count();
        $sakit = $query->where('status', 'sakit')->count();

        return compact('total', 'hadir', 'tidak_hadir', 'izin', 'sakit');
    }
}
