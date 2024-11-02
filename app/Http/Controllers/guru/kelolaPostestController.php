<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Postest;

class kelolaPostestController extends Controller
{
    public function kelolapostest()
    {
        $postest = Postest::all();
        return view('guru.kelolapostest', compact('postest'));
    }

    public function store(Request $request)
    {
        $course_id = $request->course_id;
        $request->validate([
            'postest' => 'required|string|max:255',
        ]);

        Postest::create([
            'soal_postest' => $request->postest,
            'course_id' => $course_id
        ]);

        return redirect()->route('kelolapostest')->with('success', 'postest berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $postest = Postest::find($id);

        // Hapus postest
        if ($postest) {
            $postest->delete();
            return redirect()->route('kelolapostest')->with('success', 'postest berhasil dihapus.');
        } else {
            return redirect()->route('kelolapostest')->with('error', 'postest tidak ditemukan.');
        }
    }
}
