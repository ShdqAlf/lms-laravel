<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Modul;
use App\Models\Ppt;
use App\Models\Lkpd;
use App\Models\Silabus;
use App\Models\lkpdKelompok;

class kelolaMateriController extends Controller
{
    public function kelolaMateri()
    {
        // Ambil semua course untuk ditampilkan di dropdown
        $courses = Course::all();

        // Tampilkan halaman pemilihan course
        return view('guru.pilihcourse', compact('courses'));
    }

    public function showKelolaMateri($course_id)
    {
        // Ambil data Modul, PPT, LKPD, dan Silabus berdasarkan course yang dipilih
        $modul = Modul::where('course_id', $course_id)->first();
        $ppt = Ppt::where('course_id', $course_id)->first();
        $lkpd = Lkpd::where('course_id', $course_id)->first();
        $silabus = Silabus::where('course_id', $course_id)->first();
        $lkpdkelompok = lkpdKelompok::where('course_id', $course_id)->get();

        // Ambil data course yang dipilih
        $course = Course::findOrFail($course_id);

        return view('guru.kelolamateri', compact('modul', 'ppt', 'lkpd', 'silabus', 'course', 'lkpdkelompok'));
    }

    public function store(Request $request)
    {
        $course_id = $request->course_id;

        // Update atau Tambahkan Silabus
        Silabus::updateOrCreate(
            ['course_id' => $course_id],
            [
                'deskripsi_silabus' => $request->deskripsi_silabus,
            ]
        );

        // Update atau Tambahkan Modul
        if ($request->hasFile('pdf_modul')) {
            $file = $request->file('pdf_modul');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = base_path('../public_html/storage/modul_files'); // Path ke public_html/storage

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true); // Buat folder jika belum ada
            }

            $file->move($destination, $filename);

            Modul::updateOrCreate(
                ['course_id' => $course_id],
                [
                    'deskripsi_modul' => $request->deskripsi_modul,
                    'pdf_modul' => 'storage/modul_files/' . $filename, // Simpan path relatif untuk database
                ]
            );
        }

        // Update atau Tambahkan PPT
        Ppt::updateOrCreate(
            ['course_id' => $course_id],
            [
                'judul_ppt' => $request->judul_ppt,
                'link_ppt' => $request->link_ppt,
            ]
        );

        // Update atau Tambahkan LKPD
        if ($request->hasFile('pdf_lkpd')) {
            $file = $request->file('pdf_lkpd');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = base_path('../public_html/storage/lkpd_files'); // Path ke public_html/storage

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true); // Buat folder jika belum ada
            }

            $file->move($destination, $filename);

            Lkpd::updateOrCreate(
                ['course_id' => $course_id],
                [
                    'deskripsi_lkpd' => $request->deskripsi_lkpd,
                    'pdf_lkpd' => 'storage/lkpd_files/' . $filename, // Simpan path relatif untuk database
                ]
            );
        }

        return redirect()->route('kelolamateri')->with('success', 'Data berhasil disimpan!');
    }

    public function storelkpdkelompok(Request $request)
    {
        $course_id = $request->course_id;
        $lkpdkelompok = $request->lkpdkelompok;

        lkpdKelompok::create([
            'soal_lkpd' => $lkpdkelompok,
            'course_id' => $course_id
        ]);

        return redirect()->route('kelolamateri')->with('success', 'LKPD Kelompok berhasil ditambahkan.');
    }


    public function deletelkpdkelompok($id)
    {
        $lkpdkelompok = lkpdKelompok::find($id);

        // Hapus lkpdkelompok
        if ($lkpdkelompok) {
            $lkpdkelompok->delete();
            return redirect()->route('kelolamateri')->with('success', 'lkpd kelompok berhasil dihapus.');
        } else {
            return redirect()->route('kelolamateri')->with('error', 'lkpd kelompok tidak ditemukan.');
        }
    }

    public function updatelkpdkelompok(Request $request)
    {
        $lkpdkelompok = lkpdKelompok::find($request->id);  // Cari pretest berdasarkan ID

        if ($lkpdkelompok) {
            // Update pretest dengan data baru
            $lkpdkelompok->update([
                'soal_lkpd' => $request->pretest,
                'course_id' => $request->course_id  // Pastikan course_id disertakan
            ]);

            return redirect()->route('kelolamateri')->with('success', 'LKPD Kelompok berhasil diperbarui.');
        } else {
            return redirect()->route('kelolamateri')->with('error', 'LKPD Kelompok tidak ditemukan.');
        }
    }

    public function viewPdf($id)
    {
        // Ambil semua course untuk ditampilkan di dropdown
        $courses = Course::all();
        // Ambil data modul berdasarkan ID
        $modul = Modul::findOrFail($id);

        // Pastikan file PDF ada
        if (!file_exists(public_path($modul->pdf_modul))) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        // Kirim data modul ke view
        return view('guru.viewpdf', compact('modul', 'courses'));
    }
}
