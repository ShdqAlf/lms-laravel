<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\nilaiPretest;
use App\Models\NilaiPostest;
use App\Models\nilaiLkpd;
use App\Models\Course;

class leaderboardController extends Controller
{
    public function leaderboard()
    {
        $courses = Course::all();
        $students = User::where('role', 'siswa')->get();

        $students = $students->map(function ($student) use ($courses) {
            // Ambil nilai pretest
            $nilaiPretest = NilaiPretest::where('user_id', $student->id)->first();
            $student->nilaiPretest = $nilaiPretest ? $nilaiPretest->score : 0;

            // Ambil nilai postest
            $nilaiPostest = NilaiPostest::where('user_id', $student->id)->first();
            $student->nilaiPostest = $nilaiPostest ? $nilaiPostest->score : 0;

            // Array sementara untuk nilai LKPD setiap course
            $nilaiLkpdArray = [];
            $totalLkpdScore = 0;
            $lkpdCount = 0;

            foreach ($courses as $course) {
                $nilaiLkpd = nilaiLkpd::where('user_id', $student->id)
                    ->where('lkpd_id', $course->id)
                    ->first();
                $score = $nilaiLkpd ? $nilaiLkpd->score : 0;
                $nilaiLkpdArray[$course->id] = $score;
                $totalLkpdScore += $score;
                $lkpdCount++;
            }

            // Tambahkan array nilai LKPD dan hitung rata-rata
            $student->nilaiLkpdArray = $nilaiLkpdArray;
            $totalScore = $student->nilaiPretest + $totalLkpdScore + $student->nilaiPostest;
            $student->averageScore = $lkpdCount > 0 ? $totalScore / ($lkpdCount + 2) : 0;

            return $student;
        });

        return view('leaderboard.leaderboard', compact('students', 'courses'));
    }
}
