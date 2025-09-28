<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MuridImport;

class MuridController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')->with('kelas');

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

        $murid = $query->paginate(10);
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
}
