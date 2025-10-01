<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MuridImport;
use App\Exports\MuridExport;

class MuridController extends Controller
{
    public function index(Request $request)
{
    $query = User::where('role', 'student')->with('kelas', 'presensi');

    // Filter berdasarkan kelas
    if ($request->has('kelas_id') && $request->kelas_id != '') {
        $query->where('kelas_id', $request->kelas_id);
    }

    // Filter berdasarkan pencarian
    if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('nis', 'like', '%' . $request->search . '%');
        });
    }

    // Tentukan jumlah per halaman
    $perPage = $request->get('per_page', 10);
    $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

    // Order by name
    $query->orderBy('name', 'asc');

    $murid = $query->paginate($perPage);
    $kelas = Kelas::all();

    return view('admin.murid.index', compact('murid', 'kelas'));
}

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.murid.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|string|unique:users,nis',
            'kelas_id' => 'required|exists:kelas,id',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'kelas_id' => $request->kelas_id,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        // Update jumlah siswa di kelas
        $user->kelas->updateJumlahSiswa();

        return redirect()->route('admin.murid.index')
                        ->with('success', 'Murid berhasil ditambahkan');
    }

    public function show(User $murid)
    {
        $murid->load('kelas', 'presensi');
        return view('admin.murid.show', compact('murid'));
    }

    public function edit(User $murid)
    {
        $kelas = Kelas::all();
        return view('admin.murid.edit', compact('murid', 'kelas'));
    }

    public function update(Request $request, User $murid)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $murid->id,
            'nis' => 'required|string|unique:users,nis,' . $murid->id,
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $oldKelasId = $murid->kelas_id;

        $murid->update($request->only(['name', 'email', 'nis', 'kelas_id']));

        // Update password jika diisi
        if ($request->filled('password')) {
            $murid->update(['password' => Hash::make($request->password)]);
        }

        // Update jumlah siswa di kelas lama dan baru jika berbeda
        if ($oldKelasId != $request->kelas_id) {
            if ($oldKelasId) {
                Kelas::find($oldKelasId)->updateJumlahSiswa();
            }
            $murid->kelas->updateJumlahSiswa();
        }

        return redirect()->route('admin.murid.index')
                        ->with('success', 'Murid berhasil diupdate');
    }

    public function destroy(User $murid)
    {
        $kelas = $murid->kelas;
        $murid->delete();

        if ($kelas) {
            $kelas->updateJumlahSiswa();
        }

        return redirect()->route('admin.murid.index')
                        ->with('success', 'Murid berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MuridImport, $request->file('file'));
            return redirect()->route('admin.murid.index')
                            ->with('success', 'Data murid berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('admin.murid.index')
                            ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }



// Tambahkan method ini ke MuridController yang sudah ada

/**
 * Enhanced index method dengan pagination yang lebih fleksibel
 */


/**
 * Bulk delete multiple students
 */
public function bulkDelete(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:users,id'
    ]);

    try {
        $deletedCount = 0;
        $updatedKelas = [];

        foreach ($request->ids as $id) {
            $murid = User::find($id);
            if ($murid && $murid->role === 'student') {
                $kelasId = $murid->kelas_id;
                $murid->delete();
                $deletedCount++;

                // Track kelas yang perlu diupdate
                if ($kelasId && !in_array($kelasId, $updatedKelas)) {
                    $updatedKelas[] = $kelasId;
                }
            }
        }

        // Update jumlah siswa untuk semua kelas yang terpengaruh
        foreach ($updatedKelas as $kelasId) {
            $kelas = Kelas::find($kelasId);
            if ($kelas) {
                $kelas->updateJumlahSiswa();
            }
        }

        return redirect()->route('admin.murid.index')
                        ->with('success', "Berhasil menghapus {$deletedCount} murid");

    } catch (\Exception $e) {
        return redirect()->route('admin.murid.index')
                        ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
    }
}

/**
 * Export students data to Excel
 */
public function export(Request $request)
{
    try {
        $query = User::where('role', 'student')->with('kelas');

        // Apply same filters as index
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        $murid = $query->orderBy('name', 'asc')->get();

        // Create export class
        return Excel::download(new MuridExport($murid), 'data-murid-' . date('Y-m-d') . '.xlsx');

    } catch (\Exception $e) {
        return redirect()->route('admin.murid.index')
                        ->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
    }
}

/**
 * Get student statistics for dashboard cards
 */
public function getStatistics()
{
    $today = date('Y-m-d');

    return [
        'total_murid' => User::where('role', 'student')->count(),
        'total_kelas' => Kelas::count(),
        'hadir_hari_ini' => \App\Models\Presensi::where('tanggal', $today)
                                               ->where('status', 'hadir')
                                               ->count(),
        'tidak_hadir_hari_ini' => \App\Models\Presensi::where('tanggal', $today)
                                                      ->where('status', 'tidak_hadir')
                                                      ->count(),
    ];
}

/**
 * Reset password for student
 */
public function resetPassword(Request $request, User $murid)
{
    $request->validate([
        'password' => 'required|min:8|confirmed'
    ]);

    try {
        $murid->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.murid.show', $murid->id)
                        ->with('success', 'Password berhasil direset');

    } catch (\Exception $e) {
        return redirect()->route('admin.murid.show', $murid->id)
                        ->with('error', 'Gagal mereset password: ' . $e->getMessage());
    }
}

}



