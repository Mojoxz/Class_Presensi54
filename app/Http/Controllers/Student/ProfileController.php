<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('student.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            // Upload foto profil
            if ($request->hasFile('foto_profil')) {
                $file = $request->file('foto_profil');

                // Validasi file valid
                if ($file->isValid()) {
                    // Hapus foto lama jika ada
                    if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                        Storage::disk('public')->delete($user->foto_profil);
                    }

                    // Simpan foto baru dengan nama unik
                    $fileName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('profil', $fileName, 'public');
                    $data['foto_profil'] = $path;

                    \Log::info('Foto profil berhasil diupload', [
                        'user_id' => $user->id,
                        'path' => $path,
                        'full_path' => storage_path('app/public/' . $path)
                    ]);
                }
            }

            // Update user
            $user->update($data);

            \Log::info('User berhasil diupdate', [
                'user_id' => $user->id,
                'data' => $data
            ]);

            return redirect()->back()->with('success', 'Profile berhasil diperbarui!');

        } catch (\Exception $e) {
            \Log::error('Error update profile', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui profile: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
            'password_changed_at' => now()
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}
