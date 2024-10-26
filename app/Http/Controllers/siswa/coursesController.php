<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Modul;
use App\Models\Ppt;
use App\Models\Lkpd;
use App\Models\Silabus;

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
}
