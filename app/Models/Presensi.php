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
        'foto_masuk',
        'foto_keluar',
        'foto_bukti',
        'status',
        'keterangan',
        'alasan',
        'is_approved',
        'approved_at',
        'approved_by',
        'alasan_penolakan',
        'rejected_at',
        'rejected_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Admin yang approve
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relasi ke Admin yang reject
     */
    public function rejecter()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Get presensi hari ini
     */
    public static function getPresensiToday($userId)
    {
        return self::where('user_id', $userId)
                   ->where('tanggal', Carbon::today())
                   ->first();
    }

    /**
     * Get statistik presensi
     */
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
        $hadir = (clone $query)->where('status', 'hadir')->count();
        $tidak_hadir = (clone $query)->where('status', 'tidak_hadir')->count();
        $izin = (clone $query)->where('status', 'izin')->count();
        $sakit = (clone $query)->where('status', 'sakit')->count();

        return compact('total', 'hadir', 'tidak_hadir', 'izin', 'sakit');
    }

    /**
     * Scope untuk presensi yang menunggu approval
     */
    public function scopePendingApproval($query)
    {
        return $query->whereIn('status', ['izin', 'sakit'])
                    ->whereNull('is_approved');
    }

    /**
     * Scope untuk presensi yang sudah diapprove
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope untuk presensi yang ditolak
     */
    public function scopeRejected($query)
    {
        return $query->where('is_approved', false)
                    ->whereNotNull('rejected_at');
    }

    /**
     * Accessor untuk status badge color
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'hadir' => 'bg-green-100 text-green-800',
            'izin' => 'bg-yellow-100 text-yellow-800',
            'sakit' => 'bg-blue-100 text-blue-800',
            'tidak_hadir' => 'bg-red-100 text-red-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Accessor untuk approval status
     */
    public function getApprovalStatusAttribute()
    {
        if (!in_array($this->status, ['izin', 'sakit'])) {
            return null;
        }

        if ($this->is_approved === true) {
            return 'approved';
        } elseif ($this->is_approved === false) {
            return 'rejected';
        } else {
            return 'pending';
        }
    }

    /**
     * Accessor untuk approval badge HTML
     */
    public function getApprovalBadgeAttribute()
    {
        if ($this->approval_status === 'approved') {
            return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">✓ Disetujui</span>';
        } elseif ($this->approval_status === 'rejected') {
            return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">✗ Ditolak</span>';
        } elseif ($this->approval_status === 'pending') {
            return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">⏳ Menunggu</span>';
        }
        return '';
    }

    /**
     * Check apakah terlambat
     */
    public function isTerlambat()
    {
        if (!$this->jam_masuk) {
            return false;
        }

        $batasWaktu = Carbon::parse($this->tanggal)->setTime(7, 30, 0);
        return $this->jam_masuk->isAfter($batasWaktu);
    }

    /**
     * Get durasi keterlambatan dalam menit
     */
    public function getDurasiTerlambatAttribute()
    {
        if (!$this->isTerlambat()) {
            return 0;
        }

        $batasWaktu = Carbon::parse($this->tanggal)->setTime(7, 30, 0);
        return $batasWaktu->diffInMinutes($this->jam_masuk);
    }

    /**
     * Get durasi hadir (jam masuk - jam keluar)
     */
    public function getDurasiHadirAttribute()
    {
        if (!$this->jam_masuk || !$this->jam_keluar) {
            return null;
        }

        $diff = $this->jam_masuk->diff($this->jam_keluar);
        return sprintf('%d jam %d menit', $diff->h, $diff->i);
    }

    /**
     * Helper untuk format jam masuk
     */
    public function getJamMasukFormatted()
    {
        return $this->jam_masuk ? $this->jam_masuk->format('H:i:s') : '-';
    }

    /**
     * Helper untuk format jam keluar
     */
    public function getJamKeluarFormatted()
    {
        return $this->jam_keluar ? $this->jam_keluar->format('H:i:s') : '-';
    }
}
