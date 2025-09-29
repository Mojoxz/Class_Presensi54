<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with('user')->latest()->paginate(10);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048',
            'is_published' => 'boolean'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['is_published'] = $request->has('is_published');

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Pastikan direktori ada
            $path = public_path('storage/berita');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            // Cek apakah Intervention Image tersedia
            if (class_exists('Intervention\Image\Facades\Image')) {
                $img = \Intervention\Image\Facades\Image::make($image->getRealPath());
                $img->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path . '/' . $filename);
            } else {
                // Fallback jika Intervention Image tidak tersedia
                $image->move($path, $filename);
            }

            $data['gambar'] = 'berita/' . $filename;
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')
                        ->with('success', 'Berita berhasil ditambahkan');
    }

    public function show(Berita $berita)
    {
        $berita->load('user');
        return view('admin.berita.show', compact('berita'));
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_published'] = $request->has('is_published');

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($berita->gambar) {
                $oldImagePath = public_path('storage/' . $berita->gambar);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $image = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Pastikan direktori ada
            $path = public_path('storage/berita');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            // Cek apakah Intervention Image tersedia
            if (class_exists('Intervention\Image\Facades\Image')) {
                $img = \Intervention\Image\Facades\Image::make($image->getRealPath());
                $img->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path . '/' . $filename);
            } else {
                // Fallback jika Intervention Image tidak tersedia
                $image->move($path, $filename);
            }

            $data['gambar'] = 'berita/' . $filename;
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')
                        ->with('success', 'Berita berhasil diupdate');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            $imagePath = public_path('storage/' . $berita->gambar);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
                        ->with('success', 'Berita berhasil dihapus');
    }
}
