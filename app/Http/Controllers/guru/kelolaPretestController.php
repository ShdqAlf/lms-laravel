<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pretest;
use App\Models\PretestPg;

class kelolaPretestController extends Controller
{
    public function kelolapretest()
    {
        $pretestUraian = Pretest::all();
        $pretestPilihanGanda = PretestPg::all();
        return view('guru.kelolapretest', compact('pretestUraian', 'pretestPilihanGanda'));
    }

    public function store(Request $request)
    {
        $course_id = $request->course_id;
        $pretest = $request->pretest;
        $jenisSoal = $request->jenisSoal;

        // Cek jenis soal dan simpan sesuai dengan jenisnya
        if ($jenisSoal == 'pilihanGanda') {
            $is_correct = $request->input('is_correct'); // Menyimpan jawaban yang benar

            PretestPg::create([
                'soal_pretest' => $pretest,
                'opsi_a' => $request->opsi_a,
                'opsi_b' => $request->opsi_b,
                'opsi_c' => $request->opsi_c,
                'opsi_d' => $request->opsi_d,
                'is_correct' => $is_correct, // Menyimpan jawaban yang benar
                'course_id' => $course_id,
            ]);
        } else if ($jenisSoal == 'uraian') {
            Pretest::create([
                'soal_pretest' => $pretest,
                'course_id' => $course_id,
            ]);
        }

        return redirect()->route('kelolapretest')->with('success', 'Pretest berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        if ($request->has('opsi_a') && $request->has('opsi_b') && $request->has('opsi_c') && $request->has('opsi_d')) {
            // Update Pilihan Ganda
            $pretest = PretestPg::find($request->id);
            $pretest->soal_pretest = $request->pretest;
            $pretest->opsi_a = $request->opsi_a;
            $pretest->opsi_b = $request->opsi_b;
            $pretest->opsi_c = $request->opsi_c;
            $pretest->opsi_d = $request->opsi_d;
            $pretest->is_correct = $request->is_correct;
        } else {
            // Update Uraian
            $pretest = Pretest::find($request->id);
            $pretest->soal_pretest = $request->pretest;
        }

        $pretest->save();

        return redirect()->route('kelolapretest')->with('success', 'Pretest berhasil diperbarui!');
    }

    public function delete($id, $type)
    {
        if ($type == 'pilihanGanda') {
            $pretest = PretestPg::find($id); // Model for pilihan ganda questions
        } else {
            $pretest = Pretest::find($id); // Model for uraian questions
        }

        // Hapus pretest
        if ($pretest) {
            $pretest->delete();
            return redirect()->route('kelolapretest')->with('success', 'Pretest berhasil dihapus.');
        } else {
            return redirect()->route('kelolapretest')->with('error', 'Pretest tidak ditemukan.');
        }
    }
}
