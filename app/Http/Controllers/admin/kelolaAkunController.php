<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class kelolaAkunController extends Controller
{
    /**
     * Menampilkan halaman kelola akun dengan daftar pengguna.
     */
    public function kelolaakun()
    {
        $users = User::with('course')->get(); // Mengambil data user beserta relasi course
        $courses = Course::all(); // Mengambil semua data course untuk pilihan dropdown di modal
        return view('admin.kelolaakun', compact('users', 'courses'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_id' => 'required|string|max:255|unique:users,nomor_id',
            'password' => 'required|string|min:8',
            'role' => 'required|in:guru,siswa,admin',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        // Buat akun baru
        User::create([
            'nama' => $request->nama,
            'nomor_id' => $request->nomor_id,
            'password' => Hash::make($request->password), // Hash password
            'role' => $request->role,
            'course_id' => $request->role === 'guru' ? $request->course_id : null, // Set course_id jika role adalah 'guru'
        ]);

        return redirect()->route('kelolaakun')->with('success', 'Akun berhasil ditambahkan.');
    }

    /**
     * Update data pengguna berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|in:guru,siswa,admin',
            'course_id' => 'nullable|exists:courses,id', // Nullable jika role bukan guru
        ]);

        // Update data user
        $user->update([
            'nama' => $request->nama,
            'role' => $request->role,
            'course_id' => $request->role === 'guru' ? $request->course_id : null, // Set course_id hanya jika role adalah 'guru'
        ]);

        return redirect()->route('kelolaakun')->with('success', 'Data akun berhasil diperbarui.');
    }

    /**
     * Mengganti password pengguna berdasarkan ID.
     */
    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);

        // Validasi input password
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Update password user
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('kelolaakun')->with('success', 'Password berhasil diganti.');
    }

    /**
     * Menghapus akun pengguna berdasarkan ID.
     */
    public function delete($id)
    {
        $user = User::find($id);

        // Hapus user
        if ($user) {
            $user->delete();
            return redirect()->route('kelolaakun')->with('success', 'Akun berhasil dihapus.');
        } else {
            return redirect()->route('kelolaakun')->with('error', 'Akun tidak ditemukan.');
        }
    }
}
