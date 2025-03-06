<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\jawabanPostest;
use App\Models\nilaiPostest;

class penilaianPostestController extends Controller
{
    public function penilaianpostest()
    {
        // Mengambil semua data siswa
        $students = User::where('role', 'siswa')->get();

        // Mengambil status pengisian postest dan nilai untuk setiap siswa
        $students = $students->map(function ($student) {
            $hasAnswered = jawabanPostest::where('user_id', $student->id)->exists();
            $student->status_pengisian = $hasAnswered ? 'Sudah Mengisi' : 'Belum Mengisi';

            // Ambil nilai dari tabel nilai_postest jika sudah dinilai
            $nilai = nilaiPostest::where('user_id', $student->id)->first();
            $student->nilai = $nilai ? $nilai->score : 'Belum Dinilai';

            return $student;
        });

        return view('guru.penilaianpostest', compact('students'));
    }


    public function lihatJawabanPostest($user_id)
    {
        $jawabanPostests = jawabanPostest::where('user_id', $user_id)->get();
        return view('guru.lihatjawabanPostest', compact('jawabanPostests', 'user_id'));
    }


    public function storeScore(Request $request, $user_id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        foreach ($request->input('postest_id') as $postest_id) {
            nilaiPostest::updateOrCreate(
                ['user_id' => $user_id, 'postest_id' => $postest_id],
                ['score' => $request->input('nilai')]
            );
        }

        return redirect()->route('penilaianpostest')->with('success', 'Siswa berhasil diberi nilai.');
    }
}
