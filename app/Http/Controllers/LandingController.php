<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

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
                       ->paginate(6);

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
        return view('landing.kontak');
    }
}
