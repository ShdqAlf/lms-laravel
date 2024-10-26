<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pretest;

class kelolaPretestController extends Controller
{
    public function kelolapretest()
    {
        $pretest = Pretest::all();
        return view('guru.kelolapretest', compact('pretest'));
    }

    public function store(Request $request)
    {
        $course_id = $request->course_id;
        $request->validate([
            'pretest' => 'required|string|max:255',
        ]);

        Pretest::create([
            'soal_pretest' => $request->pretest,
            'course_id' => $course_id
        ]);

        return redirect()->route('kelolapretest')->with('success', 'Pretest berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $pretest = Pretest::find($id);

        // Hapus pretest
        if ($pretest) {
            $pretest->delete();
            return redirect()->route('kelolapretest')->with('success', 'Pretest berhasil dihapus.');
        } else {
            return redirect()->route('kelolapretest')->with('error', 'Pretest tidak ditemukan.');
        }
    }
}
