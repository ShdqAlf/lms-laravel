<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\nilaiPretest;

class leaderboardController extends Controller
{
    public function leaderboard()
    {
        // Mengambil semua data siswa
        $students = User::where('role', 'siswa')->get();

        // Mengambil status pengisian pretest dan nilai untuk setiap siswa
        $students = $students->map(function ($student) {
            // $hasAnswered = JawabanPretest::where('user_id', $student->id)->exists();
            // $student->status_pengisian = $hasAnswered ? 'Sudah Mengisi' : 'Belum Mengisi';

            // Ambil nilai dari tabel nilai_pretest jika sudah dinilai
            $nilai = nilaiPretest::where('user_id', $student->id)->first();
            $student->nilai = $nilai ? $nilai->score : '-';

            return $student;
        });
        return view('leaderboard.leaderboard', compact('students'));
    }
}
