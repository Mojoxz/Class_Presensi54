<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('siswa')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas',
            'wali_kelas' => 'required|string|max:255',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')
                        ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function show(Kelas $kelas)
    {
        $kelas->load('siswa');
        return view('admin.kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas,' . $kelas->id,
            'wali_kelas' => 'required|string|max:255',
        ]);

        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')
                        ->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy(Kelas $kelas)
    {
        if ($kelas->siswa()->count() > 0) {
            return redirect()->route('admin.kelas.index')
                            ->with('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa');
        }

        $kelas->delete();

        return redirect()->route('admin.kelas.index')
                        ->with('success', 'Kelas berhasil dihapus');
    }
}
