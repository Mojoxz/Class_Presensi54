<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Kontak;

class LandingController extends Controller
{
    public function index()
    {
        $berita = Berita::where('is_published', true)
                       ->latest()
                       ->take(3)
                       ->get();

        return view('landing.index', compact('berita'));
    }

    public function tentang()
    {
        return view('landing.tentang');
    }

    public function berita()
    {
        $berita = Berita::where('is_published', true)
                       ->latest()
                       ->paginate(7);

        return view('landing.berita', compact('berita'));
    }

    public function detailBerita($id)
    {
        $berita = Berita::where('is_published', true)
                       ->findOrFail($id);

        return view('landing.berita-detail', compact('berita'));
    }

    public function kontak()
    {
        // Ambil pesan yang sudah disetujui untuk ditampilkan (3 terbaru)
        $pesan_ditampilkan = Kontak::where('is_displayed', true)
                                   ->latest()
                                   ->take(3)
                                   ->get();

        return view('landing.kontak', compact('pesan_ditampilkan'));
    }

    public function submitKontak(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'subject.required' => 'Subjek harus diisi',
            'message.required' => 'Pesan harus diisi',
            'message.min' => 'Pesan minimal 10 karakter'
        ]);

        Kontak::create([
            'nama' => $validated['name'],
            'email' => $validated['email'],
            'telepon' => $validated['phone'],
            'subjek' => $validated['subject'],
            'pesan' => $validated['message'],
            'is_displayed' => false, // default tidak ditampilkan
            'is_read' => false
        ]);

        return redirect()->route('kontak')
                        ->with('success', 'Terima kasih! Pesan Anda telah berhasil dikirim. Tim kami akan segera menghubungi Anda.');
    }
}
