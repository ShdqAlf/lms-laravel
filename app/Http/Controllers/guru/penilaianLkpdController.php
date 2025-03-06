<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelompok;
use App\Models\Course;
use App\Models\pengumpulanLkpd;
use App\Models\nilaiLkpd;
use App\Models\jawabanLkpdKelompok;
use App\Models\nilaiLkpdKelompok;

class penilaianLkpdController extends Controller
{
    public function pilihLkpd()
    {
        // Ambil semua course untuk ditampilkan di dropdown
        $courses = Course::all();

        // Tampilkan halaman pemilihan course
        return view('guru.pilihlkpd', compact('courses'));
    }

    public function pilihLkpdKelompok()
    {
        // Ambil semua course untuk ditampilkan di dropdown
        $courses = Course::all();

        // Tampilkan halaman pemilihan course
        return view('guru.pilihlkpdkelompok', compact('courses'));
    }

    public function penilaianLkpd($course_id)
    {
        $students = User::where('role', 'siswa')->get();

        $students = $students->map(function ($student) use ($course_id) {
            $hasAnswered = pengumpulanLkpd::where('user_id', $student->id)
                ->where('course_id', $course_id)
                ->exists();
            $student->status_pengisian = $hasAnswered ? 'Sudah Mengisi' : 'Belum Mengisi';

            $nilai = nilaiLkpd::where('user_id', $student->id)
                ->where('lkpd_id', $course_id)
                ->first();
            $student->nilai = $nilai ? $nilai->score : 'Belum Dinilai';

            $pengumpulan = pengumpulanLkpd::where('user_id', $student->id)
                ->where('course_id', $course_id)
                ->first();
            $student->nama_file = $pengumpulan ? $pengumpulan->nama_file : 'Belum Mengumpulkan';
            $student->file_jawaban = $pengumpulan ? $pengumpulan->file_jawaban : '#';

            return $student;
        });

        // Tambahkan $course_id dalam compact
        return view('guru.penilaianlkpd', compact('students', 'course_id'));
    }

    public function penilaianLkpdKelompok($course_id)
    {
        // Mengambil semua data kelompok dengan relasi 'users'
        $kelompok = Kelompok::with(['users' => function ($query) {
            // Mengambil status pengisian untuk setiap siswa
            $query->with(['jawabanLkpdKelompok' => function ($q) {
                $q->select('user_id'); // Pilih data yang diperlukan
            }]);
        }])->get();

        // Tidak perlu lagi mengambil $students di sini karena sudah ada dalam $kelompok
        return view('guru.penilaianlkpdkelompok', compact('kelompok'));
    }

    public function simpanNilai(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'score' => 'required|numeric|min:0|max:100'
        ]);

        // Simpan atau update nilai ke tabel nilai_lkpd
        nilaiLkpd::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'lkpd_id' => $request->course_id
            ],
            [
                'score' => $request->score
            ]
        );

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }
}
