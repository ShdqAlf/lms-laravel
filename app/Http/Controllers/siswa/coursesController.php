<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Modul;
use App\Models\Ppt;
use App\Models\Lkpd;
use App\Models\Silabus;
use App\Models\pengumpulanLkpd;
use App\Models\manualBook;
use App\Models\lkpdKelompok;
use App\Models\jawabanLkpdKelompok;
use App\Models\jawabanPretest;
use App\Models\pembagianTugas;
use Auth;

class coursesController extends Controller
{
    public function course($id)
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id); // Ambil data user

        // Mengecek apakah siswa sudah mengerjakan pretest
        $hasPretest = jawabanPretest::where('user_id', $user_id)->exists();

        // Jika belum mengerjakan pretest, arahkan kembali ke dashboard dengan pesan
        if (!$hasPretest) {
            return redirect()->route('dashboard') // Pastikan ini merujuk ke route dashboard
                ->with('error', 'Kamu belum mengerjakan pretest, silahkan kerjakan pretest dahulu agar bisa mengakses course');
        }

        if ($id >= $user->course_opened) {
            $user->course_opened = $id + 1;
            $user->materi_opened = 1;
            $user->save();
        }

        // Mengambil semua course untuk ditampilkan pada sidebar
        $courses = Course::all();

        // Mengambil detail course berdasarkan ID
        $course = Course::findOrFail($id);
        $modul = Modul::where('course_id', $id)->first();
        $ppt = Ppt::where('course_id', $id)->first();
        $lkpd = Lkpd::where('course_id', $id)->first();
        $silabus = Silabus::where('course_id', $id)->first();
        $lkpd_kelompok = lkpdKelompok::where('course_id', $id)->first();

        // Check if the user has already answered the postest questions
        $hasSubmitted = jawabanLkpdKelompok::where('user_id', $user_id)->where('lkpd_kelompok_id', $id)->exists();

        // Ambil nama kelompok user
        $kelompokNama = $user->kelompok ? $user->kelompok->nama_kelompok : 'Tidak ada kelompok';

        // Ambil semua anggota kelompok termasuk ketua
        $anggotaKelompok = User::where('kelompok_id', $user->kelompok_id)->get();

        // Tentukan apakah user adalah ketua
        $isKetua = $user->is_ketua == 1;

        // Format daftar anggota kelompok dengan tanda (Ketua Kelompok)
        $anggotaFormatted = [];
        foreach ($anggotaKelompok as $anggota) {
            if ($anggota->id != $user_id) { // Jangan masukkan user sendiri ke daftar anggota lainnya
                $namaAnggota = $anggota->nama;
                if ($anggota->is_ketua) {
                    $namaAnggota .= " (Ketua Kelompok)";
                }
                $anggotaFormatted[] = $namaAnggota;
            }
        }

        // Ambil semua soal LKPD kelompok berdasarkan course_id
        $soalLkpdKelompok = lkpdKelompok::where('course_id', $id)->get();

        // Ambil hanya pembagian tugas untuk kelompok user yang sedang login
        $pembagianTugas = PembagianTugas::where('course_id', $id)
            ->whereIn('anggota_id', function ($query) use ($user) {
                $query->select('id')
                    ->from('users')
                    ->where('kelompok_id', $user->kelompok_id);
            })
            ->get();


        // Format pembagian tugas untuk menampilkan di Blade
        $pembagianFormatted = [];
        foreach ($pembagianTugas as $tugas) {
            $siswa = User::find($tugas->anggota_id);
            if ($siswa) {
                $pembagianFormatted[$tugas->soal_id] = $siswa->nama;
            }
        }

        return view('siswa.course', compact(
            'courses',
            'course',
            'modul',
            'ppt',
            'lkpd',
            'silabus',
            'hasSubmitted',
            'lkpd_kelompok',
            'kelompokNama',
            'anggotaKelompok',
            'anggotaFormatted',
            'isKetua',
            'soalLkpdKelompok',
            'pembagianFormatted',
            'user'
        ));
    }

    public function storePembagianTugas(Request $request)
    {
        $course_id = $request->course_id;
        $pembagian = $request->pembagian;

        foreach ($pembagian as $soal_id => $anggota_id) {
            PembagianTugas::updateOrCreate(
                ['course_id' => $course_id, 'soal_id' => $soal_id], // Cek jika sudah ada tugas
                ['anggota_id' => $anggota_id] // Update atau insert
            );
        }

        return redirect()->back()->with('success', 'Pembagian tugas berhasil disimpan.');
    }


    public function showModul($id)
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id); // Ambil data us

        // Simpan nilai materi_opened menjadi 1 (Modul)
        $user->materi_opened = 2;
        $user->save();

        $courses = Course::all();
        $course = Course::findOrFail($id);
        $modul = Modul::findOrFail($id);
        return view('siswa.showmodul', compact('courses', 'course', 'modul'));
    }


    public function showPpt($id)
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id); // Ambil data user

        // Simpan nilai materi_opened menjadi 2 (PPT)
        $user->materi_opened = 3;
        $user->save();

        $courses = Course::all();
        $course = Course::findOrFail($id);
        $ppt = Ppt::findOrFail($id);
        return view('siswa.ppt', compact('courses', 'course', 'ppt'));
    }

    public function showLkpd($id)
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id); // Ambil data user

        // Simpan nilai materi_opened menjadi 2 (PPT)
        $user->materi_opened = 4;
        $user->save();

        $courses = Course::all();
        $course = Course::findOrFail($id);
        $lkpd = Lkpd::findOrFail($id);
        $lkpdkelompok = lkpdKelompok::where('course_id', $id)->get();
        return view('siswa.lkpd', compact('courses', 'course', 'lkpd'));
    }

    public function lkpdKelompokQuestions($id)
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id); // Ambil data user

        // Simpan nilai materi_opened menjadi 2 (PPT)
        $user->materi_opened = 6;
        $user->save();

        $courses = Course::all();
        $course = Course::findOrFail($id);
        $lkpd = Lkpd::findOrFail($id);
        $lkpdkelompok = lkpdKelompok::where('course_id', $id)->get();

        // Periksa apakah siswa sudah mengumpulkan LKPD
        $pengumpulan = jawabanLkpdKelompok::where('user_id', $user_id)->where('lkpd_kelompok_id', $id)->first();

        // Jika sudah mengumpulkan, arahkan kembali ke halaman course
        if ($pengumpulan) {
            return redirect()->route('course', ['id' => $id])->with('info', 'Kamu sudah mengumpulkan LKPD ini.');
        }

        // Jika belum mengumpulkan, lanjutkan ke halaman pengerjaan LKPD Kelompok
        return view('siswa.lkpdKelompok', compact('courses', 'course', 'lkpd', 'lkpdkelompok'));
    }


    public function storeAnswersLkpd(Request $request)
    {
        $user_id = $request->user_id;

        foreach ($request->jawaban as $postest_id => $jawaban) {
            jawabanLkpdKelompok::create([
                'lkpd_kelompok_id' => $postest_id,
                'user_id' => $user_id,
                'jawaban' => $jawaban
            ]);
        }

        // Pass the 'id' to the route
        return redirect()->route('course', ['id' => $request->course_id])->with('success', 'Jawaban Anda telah disimpan.');
    }

    public function pengumpulanLkpd($id)
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id); // Ambil data user

        // Simpan nilai materi_opened menjadi 2 (PPT)
        $user->materi_opened = 5;
        $user->save();

        $courses = Course::all();
        $course = Course::findOrFail($id);
        $lkpd = Lkpd::findOrFail($id);

        // Periksa apakah pengguna sudah mengumpulkan LKPD
        $pengumpulan = pengumpulanLkpd::where('user_id', $user_id)->where('course_id', $id)->first();
        $hasSubmitted = $pengumpulan ? true : false;
        $filePath = $hasSubmitted ? $pengumpulan->file_jawaban : null;

        return view('siswa.pengumpulanLkpd', compact('courses', 'course', 'lkpd', 'hasSubmitted', 'filePath'));
    }

    public function storePengumpulanLkpd(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'pdf_pengumpulanLkpd' => 'required|file|max:2048',
        ]);

        $course_id = $request->course_id;
        $user_id = Auth::id();

        if ($request->hasFile('pdf_pengumpulanLkpd')) {
            // Mendapatkan nama file asli
            $originalFileName = $request->file('pdf_pengumpulanLkpd')->getClientOriginalName();

            // Menentukan path penyimpanan manual ke public_html/storage/pengumpulanLkpd
            $destinationPath = base_path('../public_html/storage/pengumpulanLkpd');

            // Membuat folder jika belum ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            // Menyimpan file dengan nama acak
            $fileName = time() . '_' . $originalFileName;
            $request->file('pdf_pengumpulanLkpd')->move($destinationPath, $fileName);

            // Menyimpan path relatif untuk database
            $filePath = 'storage/pengumpulanLkpd/' . $fileName;

            // Menyimpan data ke database
            pengumpulanLkpd::updateOrCreate(
                ['course_id' => $course_id, 'user_id' => $user_id], // kondisi unik untuk update
                [
                    'nama_file' => $originalFileName, // Menyimpan nama file asli
                    'file_jawaban' => $filePath,      // Menyimpan path relatif
                ]
            );
        }

        return redirect()->route('course', ['id' => $course_id])->with('success', 'Penugasan LKPD berhasil dikumpulkan!');
    }

    public function manualBook()
    {
        $courses = Course::all();
        // Ambil data manual book terakhir yang diupload
        $manualBook = manualBook::orderBy('created_at', 'desc')->first(); // Ambil file terakhir yang diupload

        // Tampilkan halaman dengan data manual book
        return view('siswa.manualbook', compact('courses', 'manualBook'));
    }
}
