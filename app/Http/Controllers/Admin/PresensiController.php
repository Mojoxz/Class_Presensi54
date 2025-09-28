<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Presensi::with(['user', 'user.kelas']);

        // Filter berdasarkan tanggal
        if ($request->has('tanggal') && $request->tanggal) {
            $query->where('tanggal', $request->tanggal);
        } else {
            $query->where('tanggal', Carbon::today());
        }

        // Filter berdasarkan kelas
        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $presensi = $query->latest()->paginate(20);
        $kelas = Kelas::all();

        return view('admin.presensi.index', compact('presensi', 'kelas'));
    }

    public function rekap(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $kelasId = $request->get('kelas_id');

        $query = User::where('role', 'student')
                    ->with(['kelas', 'presensi' => function($q) use ($bulan, $tahun) {
                        $q->whereMonth('tanggal', $bulan)
                          ->whereYear('tanggal', $tahun);
                    }]);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $siswa = $query->get();
        $kelas = Kelas::all();

        // Hitung statistik
        $rekapData = $siswa->map(function($s) {
            $presensi = $s->presensi;
            return [
                'siswa' => $s,
                'total' => $presensi->count(),
                'hadir' => $presensi->where('status', 'hadir')->count(),
                'tidak_hadir' => $presensi->where('status', 'tidak_hadir')->count(),
                'izin' => $presensi->where('status', 'izin')->count(),
                'sakit' => $presensi->where('status', 'sakit')->count(),
            ];
        });

        return view('admin.presensi.rekap', compact('rekapData', 'kelas', 'bulan', 'tahun', 'kelasId'));
    }

    public function export(Request $request)
    {
        // Implementation for Excel export
        // You can use Laravel Excel package for this
        return response()->json(['message' => 'Export feature will be implemented']);
    }
}
