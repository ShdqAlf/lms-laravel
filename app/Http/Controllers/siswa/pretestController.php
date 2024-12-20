<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Pretest;
use App\Models\jawabanPretest;
use App\Models\NilaiPretest;
use Auth;

class PretestController extends Controller
{
    public function pretest()
    {
        $courses = Course::all();
        $user_id = Auth::id();

        // Check if the user has already answered the pretest questions
        $hasSubmitted = jawabanPretest::where('user_id', $user_id)->exists();

        // Retrieve the score if it exists
        $score = NilaiPretest::where('user_id', $user_id)->first();

        return view('siswa.pretest', compact('courses', 'hasSubmitted', 'score'));
    }

    public function showPretestQuestions()
    {
        $courses = Course::all();
        $questions = Pretest::all();
        return view('siswa.pretest_questions', compact('questions', 'courses'));
    }

    public function storeAnswers(Request $request)
    {
        $user_id = $request->user_id;

        foreach ($request->jawaban as $pretest_id => $jawaban) {
            jawabanPretest::create([
                'pretest_id' => $pretest_id,
                'user_id' => $user_id,
                'jawaban' => $jawaban
            ]);
        }

        return redirect()->route('pretest')->with('success', 'Jawaban Anda telah disimpan.');
    }
}
