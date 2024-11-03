<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Modul;
use App\Models\Ppt;
use App\Models\Lkpd;
use App\Models\Silabus;

class kelolaMateriController extends Controller
{
    public function kelolaMateri()
    {
        // Ambil semua course untuk ditampilkan di dropdown
        $courses = Course::all();

        // Tampilkan halaman pemilihan course
        return view('guru.pilihCourse', compact('courses'));
    }

    public function showKelolaMateri($course_id)
    {
        // Ambil data Modul, PPT, LKPD, dan Silabus berdasarkan course yang dipilih
        $modul = Modul::where('course_id', $course_id)->first();
        $ppt = Ppt::where('course_id', $course_id)->first();
        $lkpd = Lkpd::where('course_id', $course_id)->first();
        $silabus = Silabus::where('course_id', $course_id)->first();

        // Ambil data course yang dipilih
        $course = Course::findOrFail($course_id);

        return view('guru.kelolamateri', compact('modul', 'ppt', 'lkpd', 'silabus', 'course'));
    }

    public function store(Request $request)
    {
        $course_id = $request->course_id;


        // Update atau Tambahkan Silabus
        Silabus::updateOrCreate(
            ['course_id' => $course_id],  // Kondisi untuk update
            [
                'deskripsi_silabus' => $request->deskripsi_silabus,
            ]
        );

        // Update atau Tambahkan Modul
        if ($request->hasFile('pdf_modul')) {
            $pdf_modul = $request->file('pdf_modul')->store('modul_files', 'public');
            Modul::updateOrCreate(
                ['course_id' => $course_id],  // Kondisi untuk update
                [
                    'deskripsi_modul' => $request->deskripsi_modul,
                    'pdf_modul' => $pdf_modul
                ]
            );
        }

        // Update atau Tambahkan PPT
        Ppt::updateOrCreate(
            ['course_id' => $course_id],  // Kondisi untuk update
            [
                'judul_ppt' => $request->judul_ppt,
                'link_ppt' => $request->link_ppt
            ]
        );

        // Update atau Tambahkan LKPD
        if ($request->hasFile('pdf_lkpd')) {
            $pdf_lkpd = $request->file('pdf_lkpd')->store('lkpd_files', 'public');
            Lkpd::updateOrCreate(
                ['course_id' => $course_id],  // Kondisi untuk update
                [
                    'deskripsi_lkpd' => $request->deskripsi_lkpd,
                    'pdf_lkpd' => $pdf_lkpd
                ]
            );
        }

        return redirect()->route('kelolamateri')->with('success', 'Data berhasil disimpan!');
    }
}
