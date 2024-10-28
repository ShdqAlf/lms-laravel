<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Pretest;
use App\Models\jawabanPretest;
use Auth;

class PretestController extends Controller
{
    public function pretest()
    {
        $courses = Course::all();
        return view('siswa.pretest', compact('courses'));
    }

    public function showPretestQuestions()
    {
        $questions = Pretest::all();
        return view('siswa.pretest_questions', compact('questions'));
    }

    public function storeAnswers(Request $request, $course_id)
    {
        $user_id = Auth::id();

        foreach ($request->jawaban as $pretest_id => $jawaban) {
            jawabanPretest::create([
                'pretest_id' => $pretest_id,
                'user_id' => $user_id,
                'jawaban' => $jawaban
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Jawaban Anda telah disimpan.');
    }
}
