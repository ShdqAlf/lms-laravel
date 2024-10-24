<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Modul;
use App\Models\Ppt;
use App\Models\Lkpd;

class coursesController extends Controller
{
    // public function course()
    // {
    //     // Mengambil semua course untuk ditampilkan pada sidebar
    //     $courses = Course::all();
    //     return view('siswa.course', compact('courses'));
    // }

    public function course($id)
    {
        // Mengambil semua course untuk ditampilkan pada sidebar
        $courses = Course::all();

        // Mengambil detail course berdasarkan ID
        $course = Course::findOrFail($id);
        $modul = Modul::where('course_id', $id)->first();
        $ppt = Ppt::where('course_id', $id)->first();
        $lkpd = Lkpd::where('course_id', $id)->first();

        return view('siswa.course', compact('courses', 'course', 'modul', 'ppt', 'lkpd'));
    }
}
