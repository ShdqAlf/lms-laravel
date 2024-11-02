<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JawabanPretest;
use App\Models\nilaiPretest;

class penilaianPretestController extends Controller
{
    public function penilaianpretest()
    {
        // Mengambil semua data siswa
        $students = User::where('role', 'siswa')->get();

        // Mengambil status pengisian pretest dan nilai untuk setiap siswa
        $students = $students->map(function ($student) {
            $hasAnswered = JawabanPretest::where('user_id', $student->id)->exists();
            $student->status_pengisian = $hasAnswered ? 'Sudah Mengisi' : 'Belum Mengisi';

            // Ambil nilai dari tabel nilai_pretest jika sudah dinilai
            $nilai = nilaiPretest::where('user_id', $student->id)->first();
            $student->nilai = $nilai ? $nilai->score : 'Belum Dinilai';

            return $student;
        });

        return view('guru.penilaianpretest', compact('students'));
    }


    public function lihatJawaban($user_id)
    {
        $jawabanPretests = JawabanPretest::where('user_id', $user_id)->get();
        return view('guru.lihatjawaban', compact('jawabanPretests', 'user_id'));
    }


    public function storeScore(Request $request, $user_id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        foreach ($request->input('pretest_id') as $pretest_id) {
            nilaiPretest::updateOrCreate(
                ['user_id' => $user_id, 'pretest_id' => $pretest_id],
                ['score' => $request->input('nilai')]
            );
        }

        return redirect()->route('penilaianpretest')->with('success', 'Siswa berhasil diberi nilai.');
    }
}
