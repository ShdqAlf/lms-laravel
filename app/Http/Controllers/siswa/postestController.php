<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Postest;
use App\Models\jawabanPostest;
use App\Models\nilaiPostest;
use App\Models\PostestPg;
use App\Models\jawabanPostestPg;
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

    public function showPostestQuestions()
    {
        $courses = Course::all();
        $multipleChoiceQuestions = PostestPg::all();  // Fetch multiple-choice questions
        $essayQuestions = Postest::all();  // Fetch essay questions

        return view('siswa.postest_questions', compact('multipleChoiceQuestions', 'essayQuestions', 'courses'));
    }

    public function storeAnswers(Request $request)
    {
        $user_id = $request->user_id;

        // Loop through the submitted answers
        foreach ($request->jawaban as $pretest_id => $jawaban) {
            // Check if the question is a multiple-choice question or an essay question
            $question = PostestPg::find($pretest_id);

            if ($question) {
                // This is a multiple-choice question
                jawabanPostestPg::create([
                    'postest_pg_id' => $pretest_id, // Store the question ID
                    'user_id' => $user_id,
                    'jawaban' => $jawaban // Store the selected answer (A, B, C, D)
                ]);
            } else {
                // This is an essay question
                $question = Postest::find($pretest_id);

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
                jawabanPostest::create([
                    'postest_id' => $pretest_id,
                    'user_id' => $user_id,
                    'jawaban' => $jawaban, // Store the written answer
                    'gambar_jawaban' => $gambarPath // Store image path if available
                ]);
            }
        }


        return redirect()->route('pretest')->with('success', 'Jawaban Anda telah disimpan.');
    }
}
