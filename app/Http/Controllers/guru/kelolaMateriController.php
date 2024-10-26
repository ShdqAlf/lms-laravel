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
    public function kelolamateri()
    {
        // Dapatkan ID course berdasarkan user yang sedang login
        $course_id = auth()->user()->course->id;

        // Ambil data Modul, PPT, dan LKPD untuk course yang sedang login
        $modul = Modul::where('course_id', $course_id)->first();
        $ppt = Ppt::where('course_id', $course_id)->first();
        $lkpd = Lkpd::where('course_id', $course_id)->first();
        $silabus = Silabus::where('course_id', $course_id)->first();

        return view('guru.kelolamateri', compact('modul', 'ppt', 'lkpd', 'silabus'));
    }

    public function store(Request $request)
    {
        $course_id = $request->course_id;

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

        // Update atau Tambahkan silabus
        Silabus::updateOrCreate(
            ['course_id' => $course_id],  // Kondisi untuk update
            [
                'deskripsi_silabus' => $request->deskripsi_silabus,
            ]
        );

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}
