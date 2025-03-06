<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class kelolaKelompokController extends Controller
{
    public function kelolakelompok()
    {
        $users = User::where('role', 'siswa')->where('kelompok_id', null)->get();
        // Controller
        $kelompok = Kelompok::with('users')->get(); // Mengambil koleksi
        return view('guru.kelolakelompok', compact('users', 'kelompok'));
    }

    public function edit($id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $users = User::where('role', 'siswa')->get(); // Daftar siswa
        $anggota = $kelompok->users->pluck('id')->toArray(); // Ambil ID anggota kelompok
        return view('guru.kelolakelompok', compact('kelompok', 'users', 'anggota'));
    }



    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'course' => 'required|string|max:255',
            'anggota' => 'required|array|min:1',
            'anggota.*' => 'exists:users,id',
        ]);

        // Update data kelompok
        $kelompok = Kelompok::findOrFail($id);
        $kelompok->nama_kelompok = $request->course;
        $kelompok->save();

        // Update anggota kelompok
        foreach ($request->anggota as $index => $anggota_id) {
            $user = User::find($anggota_id);
            $user->kelompok_id = $kelompok->id;

            if ($index === 0) {
                $user->is_ketua = true;
            } else {
                $user->is_ketua = false;
            }

            $user->save();
        }

        return redirect()->route('kelolakelompok')->with('success', 'Kelompok berhasil diperbarui!');
    }


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'course' => 'required|string|max:255',
            'anggota' => 'required|array|min:1', // Minimal 1 anggota
            'anggota.*' => 'exists:users,id', // Pastikan semua anggota valid
        ]);

        // Buat kelompok baru
        $kelompok = Kelompok::create([
            'nama_kelompok' => $request->course, // Menyimpan nama kelompok
        ]);

        // Mengupdate setiap anggota dengan kelompok_id baru
        foreach ($request->anggota as $index => $anggota_id) {
            $user = User::find($anggota_id);
            $user->kelompok_id = $kelompok->id;

            // Jika ini adalah anggota pertama, set is_ketua menjadi true
            if ($index === 0) {
                $user->is_ketua = true;
            } else {
                $user->is_ketua = false;
            }

            $user->save();
        }

        // Mengembalikan respons sukses
        return redirect()->route('kelolakelompok')->with('success', 'Kelompok berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // Hapus kelompok dan reset kelompok_id untuk anggota yang terdaftar di kelompok tersebut
        $kelompok = Kelompok::findOrFail($id);
        $users = $kelompok->users;

        foreach ($users as $user) {
            $user->kelompok_id = null;
            $user->is_ketua = false;
            $user->save();
        }

        $kelompok->delete();

        return redirect()->route('kelolakelompok')->with('success', 'Kelompok berhasil dihapus!');
    }
}
