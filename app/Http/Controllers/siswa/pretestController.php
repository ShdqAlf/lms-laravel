<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Pretest;
use App\Models\PretestPg;
use App\Models\jawabanPretest;
use App\Models\jawabanPretestPg;
use App\Models\nilaiPretest;
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
        $score = nilaiPretest::where('user_id', $user_id)->first();

        return view('siswa.pretest', compact('courses', 'hasSubmitted', 'score'));
    }

    public function showPretestQuestions()
    {
        $courses = Course::all();
        $multipleChoiceQuestions = PretestPg::all();  // Fetch multiple-choice questions
        $essayQuestions = Pretest::all();  // Fetch essay questions

        return view('siswa.pretest_questions', compact('multipleChoiceQuestions', 'essayQuestions', 'courses'));
    }

    public function storeAnswers(Request $request)
    {
        $user_id = $request->user_id;

        // Loop through the submitted answers
        foreach ($request->jawaban as $pretest_id => $jawaban) {
            // Check if the question is a multiple-choice question or an essay question
            $question = PretestPg::find($pretest_id);

            if ($question) {
                // This is a multiple-choice question
                jawabanPretestPg::create([
                    'pretest_pg_id' => $pretest_id, // Store the question ID
                    'user_id' => $user_id,
                    'jawaban' => $jawaban // Store the selected answer (A, B, C, D)
                ]);
            } else {
                // This is an essay question
                $question = Pretest::find($pretest_id);

                // Inisialisasi path gambar sebagai null
                $gambarPath = null;

                // Cek apakah ada gambar yang dikirim dari canvas
                if ($request->has("gambar_canvas.$pretest_id")) {
                    $imageData = $request->input("gambar_canvas.$pretest_id");

                    if ($imageData) {
                        // Decode Base64 image
                        $image = str_replace('data:image/png;base64,', '', $imageData);
                        $image = str_replace(' ', '+', $image);
                        $imageName = 'jawaban_' . $user_id . '_' . $pretest_id . '_' . time() . '.png';

                        // Path penyimpanan di Laravel Storage
                        $destinationPath = storage_path('app/public/jawaban_pretest');

                        // Pastikan folder penyimpanan sudah ada
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }

                        // Simpan gambar ke storage Laravel
                        file_put_contents($destinationPath . '/' . $imageName, base64_decode($image));

                        // Simpan path gambar yang bisa diakses oleh public
                        $gambarPath = "jawaban_pretest/" . $imageName;
                    }
                }

                // Simpan jawaban dengan path gambar (jika ada)
                jawabanPretest::create([
                    'pretest_id' => $pretest_id,
                    'user_id' => $user_id,
                    'jawaban' => $jawaban, // Store the written answer
                    'gambar_jawaban' => $gambarPath // Store image path if available
                ]);
            }
        }


        return redirect()->route('pretest')->with('success', 'Jawaban Anda telah disimpan.');
    }
}
