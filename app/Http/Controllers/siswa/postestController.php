<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Postest;
use App\Models\jawabanPostest;
use App\Models\nilaiPostest;
use Auth;

class PostestController extends Controller
{
    public function postest()
    {
        $courses = Course::all();
        $user_id = Auth::id();

        // Check if the user has already answered the postest questions
        $hasSubmitted = jawabanPostest::where('user_id', $user_id)->exists();

        // Retrieve the score if it exists
        $score = nilaiPostest::where('user_id', $user_id)->first();

        return view('siswa.postest', compact('courses', 'hasSubmitted', 'score'));
    }

    public function showpostestQuestions()
    {
        $courses = Course::all();
        $questions = Postest::all();
        return view('siswa.postest_questions', compact('questions', 'courses'));
    }

    public function storeAnswers(Request $request)
    {
        $user_id = $request->user_id;

        foreach ($request->jawaban as $postest_id => $jawaban) {
            jawabanPostest::create([
                'postest_id' => $postest_id,
                'user_id' => $user_id,
                'jawaban' => $jawaban
            ]);
        }

        return redirect()->route('postest')->with('success', 'Jawaban Anda telah disimpan.');
    }
}
