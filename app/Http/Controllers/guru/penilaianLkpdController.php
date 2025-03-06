<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelompok;
use App\Models\Course;
use App\Models\pengumpulanLkpd;
use App\Models\nilaiLkpd;
use App\Models\lkpdKelompok;
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
        // Ambil semua LKPD kelompok yang terkait dengan course_id yang dipilih
        $lkpdKelompok = lkpdKelompok::where('course_id', $course_id)->pluck('id');

        // Ambil semua kelompok dengan data user dan jawaban
        $kelompok = Kelompok::with(['users' => function ($query) use ($lkpdKelompok) {
            $query->with(['jawabanLkpdKelompok' => function ($q) use ($lkpdKelompok) {
                $q->whereIn('lkpd_kelompok_id', $lkpdKelompok);
            }]);

            // Ambil nilai setiap user
            $query->with('nilaiLkpdKelompok');
        }])->get();

        return view('guru.penilaianlkpdkelompok', compact('kelompok', 'course_id'));
    }


    public function lihatJawabanLkpdKelompok($user_id, $course_id)
    {
        // Ambil semua ID LKPD kelompok yang sesuai dengan course_id
        $lkpdKelompokIds = lkpdKelompok::where('course_id', $course_id)->pluck('id');

        // Ambil jawaban siswa berdasarkan user_id dan course_id yang dipilih
        $jawaban = jawabanLkpdKelompok::where('user_id', $user_id)
            ->whereIn('lkpd_kelompok_id', $lkpdKelompokIds)
            ->get();

        // Ambil data siswa untuk ditampilkan di view
        $siswa = User::findOrFail($user_id);

        return view('guru.lihatjawabanlkpdkelompok', compact('jawaban', 'siswa', 'course_id'));
    }

    public function simpanNilaiLkpdKelompok(Request $request)
    {
        // Validasi input
        $request->validate([
            'kelompok_id' => 'required|exists:kelompok,id',
            'course_id' => 'required|exists:courses,id',
            'score' => 'required|numeric|min:0|max:100'
        ]);

        // Ambil semua anggota dalam kelompok
        $anggotaKelompok = User::where('kelompok_id', $request->kelompok_id)->get();

        foreach ($anggotaKelompok as $anggota) {
            // Simpan atau update nilai di database
            nilaiLkpdKelompok::updateOrCreate(
                [
                    'user_id' => $anggota->id,
                    'lkpd_kelompok_id' => $request->course_id
                ],
                [
                    'score' => $request->score
                ]
            );
        }

        return redirect()->back()->with('success', 'Nilai berhasil diberikan kepada semua anggota kelompok.');
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
