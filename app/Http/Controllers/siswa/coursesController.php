<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Modul;
use App\Models\Ppt;
use App\Models\Lkpd;
use App\Models\Silabus;
use App\Models\pengumpulanLkpd;
use Auth;

class coursesController extends Controller
{
    public function course($id)
    {
        // Mengambil semua course untuk ditampilkan pada sidebar
        $courses = Course::all();

        // Mengambil detail course berdasarkan ID
        $course = Course::findOrFail($id);
        $modul = Modul::where('course_id', $id)->first();
        $ppt = Ppt::where('course_id', $id)->first();
        $lkpd = Lkpd::where('course_id', $id)->first();
        $silabus = Silabus::where('course_id', $id)->first();

        return view('siswa.course', compact('courses', 'course', 'modul', 'ppt', 'lkpd', 'silabus'));
    }

    public function showModul($id)
    {
        $courses = Course::all();
        $course = Course::findOrFail($id);
        $modul = Modul::findOrFail($id);
        return view('siswa.showmodul', compact('courses', 'course', 'modul'));
    }

    public function showPpt($id)
    {
        $courses = Course::all();
        $course = Course::findOrFail($id);
        $ppt = Ppt::findOrFail($id);
        return view('siswa.ppt', compact('courses', 'course', 'ppt'));
    }

    public function showLkpd($id)
    {
        $courses = Course::all();
        $course = Course::findOrFail($id);
        $lkpd = Lkpd::findOrFail($id);
        return view('siswa.lkpd', compact('courses', 'course', 'lkpd'));
    }

    public function pengumpulanLkpd($id)
    {
        $user_id = Auth::id();

        $courses = Course::all();
        $course = Course::findOrFail($id);
        $lkpd = Lkpd::findOrFail($id);

        // Check if the user has already answered the postest questions
        $hasSubmitted = pengumpulanLkpd::where('user_id', $user_id)->where('course_id', $id)->exists();
        return view('siswa.pengumpulanLkpd', compact('courses', 'course', 'lkpd', 'hasSubmitted'));
    }

    public function storePengumpulanLkpd(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'pdf_pengumpulanLkpd' => 'required|file|mimes:pdf|max:2048',
        ]);

        $course_id = $request->course_id;
        $user_id = Auth::id();

        if ($request->hasFile('pdf_pengumpulanLkpd')) {
            // Mendapatkan nama file asli
            $originalFileName = $request->file('pdf_pengumpulanLkpd')->getClientOriginalName();

            // Menyimpan file di folder 'public/pengumpulanLkpd' dengan nama acak
            $filePath = $request->file('pdf_pengumpulanLkpd')->store('pengumpulanLkpd', 'public');

            // Menyimpan data ke database
            pengumpulanLkpd::updateOrCreate(
                ['course_id' => $course_id, 'user_id' => $user_id], // kondisi unik untuk update
                [
                    'nama_file' => $originalFileName, // Menyimpan nama file asli
                    'file_jawaban' => $filePath,      // Menyimpan path file acak
                ]
            );
        }

        return redirect()->route('course', ['id' => $course_id])->with('success', 'Penugasan LKPD berhasil dikumpulkan!');
    }
}
