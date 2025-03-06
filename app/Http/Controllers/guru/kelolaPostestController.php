<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Postest;
use App\Models\PostestPg;

class kelolaPostestController extends Controller
{
    public function kelolapostest()
    {
        $postestUraian = Postest::all();
        $postestPilihanGanda = PostestPg::all();
        return view('guru.kelolapostest', compact('postestUraian', 'postestPilihanGanda'));
    }

    public function store(Request $request)
    {
        $course_id = $request->course_id;
        $postest = $request->pretest;
        $jenisSoal = $request->jenisSoal;

        // Cek jenis soal dan simpan sesuai dengan jenisnya
        if ($jenisSoal == 'pilihanGanda') {
            $is_correct = $request->input('is_correct'); // Menyimpan jawaban yang benar

            PostestPg::create([
                'soal_postest' => $postest,
                'opsi_a' => $request->opsi_a,
                'opsi_b' => $request->opsi_b,
                'opsi_c' => $request->opsi_c,
                'opsi_d' => $request->opsi_d,
                'is_correct' => $is_correct, // Menyimpan jawaban yang benar
                'course_id' => $course_id,
            ]);
        } else if ($jenisSoal == 'uraian') {
            Postest::create([
                'soal_postest' => $postest,
                'course_id' => $course_id,
            ]);
        }

        return redirect()->route('kelolapostest')->with('success', 'postest berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        if ($request->has('opsi_a') && $request->has('opsi_b') && $request->has('opsi_c') && $request->has('opsi_d')) {
            // Update Pilihan Ganda
            $postest = PostestPg::find($request->id);
            $postest->soal_postest = $request->postest;
            $postest->opsi_a = $request->opsi_a;
            $postest->opsi_b = $request->opsi_b;
            $postest->opsi_c = $request->opsi_c;
            $postest->opsi_d = $request->opsi_d;
            $postest->is_correct = $request->is_correct;
        } else {
            // Update Uraian
            $postest = Postest::find($request->id);
            $postest->soal_postest = $request->postest;
        }

        $postest->save();

        return redirect()->route('kelolapostest')->with('success', 'postest berhasil diperbarui!');
    }

    public function delete($id, $type)
    {
        if ($type == 'pilihanGanda') {
            $postest = PostestPg::find($id); // Model for pilihan ganda questions
        } else {
            $postest = Postest::find($id); // Model for uraian questions
        }

        // Hapus postest
        if ($postest) {
            $postest->delete();
            return redirect()->route('kelolapostest')->with('success', 'postest berhasil dihapus.');
        } else {
            return redirect()->route('kelolapostest')->with('error', 'postest tidak ditemukan.');
        }
    }
}
