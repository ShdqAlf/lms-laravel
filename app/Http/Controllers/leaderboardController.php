<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\nilaiPretest;
use App\Models\NilaiPostest;

class leaderboardController extends Controller
{
    public function leaderboard()
    {
        // Mengambil semua data siswa
        $students = User::where('role', 'siswa')->get();

        // Mengambil status pengisian pretest dan nilai untuk setiap siswa
        $students = $students->map(function ($student) {
            // Ambil nilai dari tabel nilai_pretest jika sudah dinilai
            $nilaiPretest = NilaiPretest::where('user_id', $student->id)->first();
            $student->nilaiPretest = $nilaiPretest ? $nilaiPretest->score : '-';

            // Ambil nilai dari tabel nilai_postest jika sudah dinilai
            $nilaiPostest = NilaiPostest::where('user_id', $student->id)->first();
            $student->nilaiPostest = $nilaiPostest ? $nilaiPostest->score : '-';

            return $student;
        });

        return view('leaderboard.leaderboard', compact('students'));
    }
}
