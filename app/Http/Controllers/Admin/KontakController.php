<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index(Request $request)
    {
        $query = Kontak::query();

        // Filter berdasarkan status tampil
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'displayed') {
                $query->where('is_displayed', true);
            } elseif ($request->status === 'hidden') {
                $query->where('is_displayed', false);
            }
        }

        // Filter berdasarkan status baca
        if ($request->has('read_status') && $request->read_status !== 'all') {
            if ($request->read_status === 'read') {
                $query->where('is_read', true);
            } elseif ($request->read_status === 'unread') {
                $query->where('is_read', false);
            }
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subjek', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%");
            });
        }

        $kontak = $query->latest()->paginate(10);
        $unreadCount = Kontak::unread()->count();

        return view('admin.kontak.index', compact('kontak', 'unreadCount'));
    }

    public function show($id)
    {
        $kontak = Kontak::findOrFail($id);

        // Tandai sebagai sudah dibaca
        if (!$kontak->is_read) {
            $kontak->update(['is_read' => true]);
        }

        return view('admin.kontak.show', compact('kontak'));
    }

    public function toggleDisplay($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->update(['is_displayed' => !$kontak->is_displayed]);

        $message = $kontak->is_displayed
            ? 'Pesan berhasil ditampilkan di halaman kontak'
            : 'Pesan berhasil disembunyikan dari halaman kontak';

        return redirect()->back()->with('success', $message);
    }

    public function markAsRead($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Pesan ditandai sebagai sudah dibaca');
    }

    public function markAsUnread($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->update(['is_read' => false]);

        return redirect()->back()->with('success', 'Pesan ditandai sebagai belum dibaca');
    }

    public function destroy($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->delete();

        return redirect()->route('admin.kontak.index')
                        ->with('success', 'Pesan berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada pesan yang dipilih');
        }

        Kontak::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', count($ids) . ' pesan berhasil dihapus');
    }
}
