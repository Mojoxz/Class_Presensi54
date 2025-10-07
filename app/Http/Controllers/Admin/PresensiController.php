<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PresensiExport;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Presensi::with(['user', 'user.kelas', 'approver', 'rejecter']);

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

        // Filter berdasarkan approval status
        if ($request->has('approval_status') && $request->approval_status) {
            if ($request->approval_status === 'pending') {
                $query->pendingApproval();
            } elseif ($request->approval_status === 'approved') {
                $query->approved();
            } elseif ($request->approval_status === 'rejected') {
                $query->rejected();
            }
        }

        $presensi = $query->latest()->paginate(20);
        $kelas = Kelas::all();

        // Statistik hari ini (atau tanggal yang dipilih)
        $tanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        $statistik = [
            'total' => Presensi::whereDate('tanggal', $tanggal)->count(),
            'hadir' => Presensi::whereDate('tanggal', $tanggal)->where('status', 'hadir')->count(),
            'izin' => Presensi::whereDate('tanggal', $tanggal)->where('status', 'izin')->count(),
            'sakit' => Presensi::whereDate('tanggal', $tanggal)->where('status', 'sakit')->count(),
            'tidak_hadir' => Presensi::whereDate('tanggal', $tanggal)->where('status', 'tidak_hadir')->count(),
            'pending' => Presensi::whereDate('tanggal', $tanggal)->pendingApproval()->count(),
        ];

        return view('admin.presensi.index', compact('presensi', 'kelas', 'statistik'));
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
            $hadir = $presensi->where('status', 'hadir')->count();
            $total = $presensi->count();

            return [
                'siswa' => $s,
                'total' => $total,
                'hadir' => $hadir,
                'tidak_hadir' => $presensi->where('status', 'tidak_hadir')->count(),
                'izin' => $presensi->where('status', 'izin')->count(),
                'sakit' => $presensi->where('status', 'sakit')->count(),
                'terlambat' => $presensi->where('status', 'hadir')->filter(function($p) {
                    return $p->keterangan && str_contains($p->keterangan, 'Terlambat');
                })->count(),
                'persentase' => $total > 0 ? round(($hadir / $total) * 100, 2) : 0,
            ];
        });

        return view('admin.presensi.rekap', compact('rekapData', 'kelas', 'bulan', 'tahun', 'kelasId'));
    }

    public function detail(Request $request, $userId)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        $siswa = User::with('kelas')->findOrFail($userId);

        $presensi = Presensi::where('user_id', $userId)
                            ->with(['approver', 'rejecter'])
                            ->whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun)
                            ->orderBy('tanggal', 'desc')
                            ->get();

        // Hitung statistik
        $statistik = [
            'total' => $presensi->count(),
            'hadir' => $presensi->where('status', 'hadir')->count(),
            'tidak_hadir' => $presensi->where('status', 'tidak_hadir')->count(),
            'izin' => $presensi->where('status', 'izin')->count(),
            'sakit' => $presensi->where('status', 'sakit')->count(),
            'terlambat' => $presensi->where('status', 'hadir')->filter(function($p) {
                return $p->keterangan && str_contains($p->keterangan, 'Terlambat');
            })->count(),
            'pending' => $presensi->filter(function($p) {
                return $p->approval_status === 'pending';
            })->count(),
        ];

        return view('admin.presensi.detail', compact('siswa', 'presensi', 'statistik', 'bulan', 'tahun'));
    }

    public function export(Request $request)
    {
        $bulan = (int) $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $kelasId = $request->get('kelas_id');

        $namaBulan = Carbon::create()->month($bulan)->format('F');
        $filename = "Rekap_Presensi_{$namaBulan}_{$tahun}.xlsx";

        return Excel::download(new PresensiExport($bulan, $tahun, $kelasId), $filename);
    }

    /**
     * Approve pengajuan izin/sakit
     */
    public function approve($id)
    {
        try {
            $presensi = Presensi::findOrFail($id);

            // Validasi: hanya izin/sakit yang bisa di-approve
            if (!in_array($presensi->status, ['izin', 'sakit'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Presensi ini tidak memerlukan persetujuan'
                ], 400);
            }

            // Validasi: tidak bisa approve yang sudah pernah di-approve/reject
            if ($presensi->is_approved !== null) {
                $status = $presensi->is_approved ? 'disetujui' : 'ditolak';
                return response()->json([
                    'success' => false,
                    'message' => "Presensi ini sudah {$status} sebelumnya"
                ], 400);
            }

            $presensi->update([
                'is_approved' => true,
                'approved_at' => Carbon::now(),
                'approved_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan ' . $presensi->status . ' berhasil disetujui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject pengajuan izin/sakit
     */
    public function reject(Request $request, $id)
    {
        try {
            $presensi = Presensi::findOrFail($id);

            // Validasi: hanya izin/sakit yang bisa di-reject
            if (!in_array($presensi->status, ['izin', 'sakit'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Presensi ini tidak dapat ditolak'
                ], 400);
            }

            // Validasi: tidak bisa reject yang sudah pernah di-approve/reject
            if ($presensi->is_approved !== null) {
                $status = $presensi->is_approved ? 'disetujui' : 'ditolak';
                return response()->json([
                    'success' => false,
                    'message' => "Presensi ini sudah {$status} sebelumnya"
                ], 400);
            }

            // Validasi input alasan penolakan
            $request->validate([
                'alasan_penolakan' => 'required|string|min:10|max:500'
            ]);

            $presensi->update([
                'is_approved' => false,
                'status' => 'tidak_hadir', // Ubah status jadi tidak hadir
                'alasan_penolakan' => $request->alasan_penolakan,
                'rejected_at' => Carbon::now(),
                'rejected_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil ditolak'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alasan penolakan minimal 10 karakter',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
