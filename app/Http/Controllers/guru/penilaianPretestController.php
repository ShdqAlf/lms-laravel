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

        // Mengambil status pengisian pretest untuk setiap siswa
        $students = $students->map(function ($student) {
            $hasAnswered = JawabanPretest::where('user_id', $student->id)->exists();
            $student->status_pengisian = $hasAnswered ? 'Sudah Mengisi' : 'Belum Mengisi';
            return $student;
        });

        return view('guru.penilaianpretest', compact('students'));
    }

    public function lihatJawaban($user_id)
    {
        $jawabanPretests = JawabanPretest::where('user_id', $user_id)->get();
        return view('guru.lihatjawaban', compact('jawabanPretests'));
    }

    public function storeScore(Request $request, $user_id, $pretest_id)
    {
        $request->validate([
            'score' => 'required|integer|min:0|max:100',
        ]);

        nilaiPretest::updateOrCreate(
            ['user_id' => $user_id, 'pretest_id' => $pretest_id],
            ['score' => $request->score]
        );

        return redirect()->back()->with('success', 'Score has been saved.');
    }
}
