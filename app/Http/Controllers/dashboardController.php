<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\jadwalKegiatan;
use App\Models\jawabanPretest;
use App\Models\jawabanPostest;
use App\Models\pengumpulanLkpd;
use App\Models\nilaiPretest;
use App\Models\nilaiPostest;
use App\Models\nilaiLkpd;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Auth;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function dashboard()
    {
        $courses = Course::all();
        $user = auth()->user();

        // Ambil data siswa
        $student = $user;

        // Cek apakah siswa sudah hadir hari ini
        $hadirHariIni = Kehadiran::checkAttendance($student->id);

        // Pretest status dan nilai
        $pretestScore = NilaiPretest::where('user_id', $student->id)->value('score');
        $student->nilai_pretest = $pretestScore ?? ($this->hasSubmittedPretest($student->id) ? 'dalam penilaian' : 'belum mengisi');

        // Postest status dan nilai
        $postestScore = NilaiPostest::where('user_id', $student->id)->value('score');
        $student->nilai_postest = $postestScore ?? ($this->hasSubmittedPostest($student->id) ? 'dalam penilaian' : 'belum mengisi');

        // LKPD status dan nilai
        $nilaiLkpd = [];
        foreach ($courses as $course) {
            $score = nilaiLkpd::where('user_id', $student->id)
                ->where('lkpd_id', $course->id)
                ->value('score');

            $status = $this->hasSubmittedLkpd($student->id, $course->id)
                ? ($score ?? 'dalam penilaian')
                : 'belum mengisi';
            $nilaiLkpd[$course->id] = $status;
        }
        $student->nilai_lkpd = $nilaiLkpd;

        // Mengambil semua data siswa
        $students = User::where('role', 'siswa')->get();

        $students = $students->map(function ($student) use ($courses) {
            $hadirHariIni = Kehadiran::checkAttendance($student->id);

            // Logika untuk menentukan status kehadiran
            $answeredPretest = JawabanPretest::where('user_id', $student->id)->exists();
            $answeredPostest = JawabanPostest::where('user_id', $student->id)->exists();

            if (!$answeredPretest) {
                $student->status_kehadiran = 'Pretest';
            } elseif ($answeredPretest && !$answeredPostest) {
                $course = Course::find($student->course_opened);
                $student->status_kehadiran = $course ? $course->course : 'Course Not Found';
            } elseif ($answeredPostest) {
                $student->status_kehadiran = 'Postest';
            } else {
                $student->status_kehadiran = '❌'; // Default status jika tidak ada kondisi yang terpenuhi
            }

            $student->status_pengisian_pretest = $answeredPretest ? 'Sudah Mengisi' : 'Belum Mengisi';
            $student->status_pengisian_postest = $answeredPostest ? 'Sudah Mengisi' : 'Belum Mengisi';

            // Variabel sementara untuk menyimpan status pengisian tiap course
            $statusLkpd = [];

            foreach ($courses as $course) {
                $answeredLkpd = pengumpulanLkpd::where('user_id', $student->id)
                    ->where('course_id', $course->id)
                    ->exists();
                $statusLkpd[$course->id] = $answeredLkpd ? 'Sudah Mengisi' : 'Belum Mengisi';
            }

            // Menyimpan status LKPD sebagai atribut tambahan pada objek $student
            $student->status_pengisian_lkpd = $statusLkpd;

            return $student;
        });

        // Menghitung jumlah siswa yang belum mengumpulkan pretest
        $jumlahBelumPretest = $students->where('status_pengisian_pretest', 'Belum Mengisi')->count();

        // Menghitung jumlah siswa yang belum mengumpulkan postest
        $jumlahBelumPostest = $students->where('status_pengisian_postest', 'Belum Mengisi')->count();

        // Menghitung jumlah siswa yang belum mengumpulkan LKPD untuk setiap course
        $jumlahBelumLkpd = [];
        foreach ($courses as $course) {
            $jumlahBelumLkpd[$course->id] = $students->filter(function ($student) use ($course) {
                return $student->status_pengisian_lkpd[$course->id] === 'Belum Mengisi';
            })->count();
        }

        // Modify query to include the user's name and role
        $eventsQuery = jadwalKegiatan::select(
            'deskripsi_kegiatan as title',
            'tanggal_kegiatan as start',
            'user_id'
        )->with('user:id,nama,role'); // Assuming 'nama' and 'role' fields exist in the 'users' table

        if ($user->role === 'guru') {
            $events = $eventsQuery->get()->map(function ($event) {
                $event->color = $event->user->role === 'guru' ? 'blue' : 'green';
                return $event;
            })->toArray();
        } else {
            $events = $eventsQuery->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('user', function ($query) {
                        $query->where('role', 'guru');
                    });
            })->get()->map(function ($event) {
                $event->color = $event->user->role === 'guru' ? 'blue' : 'green';
                return $event;
            })->toArray();
        }

        return view('dashboard.dashboard', compact('courses', 'events', 'students', 'jumlahBelumPretest', 'jumlahBelumPostest', 'jumlahBelumLkpd', 'student', 'hadirHariIni'));
    }

    private function hasSubmittedPretest($userId)
    {
        return JawabanPretest::where('user_id', $userId)->exists();
    }

    private function hasSubmittedPostest($userId)
    {
        return JawabanPostest::where('user_id', $userId)->exists();
    }

    private function hasSubmittedLkpd($userId, $courseId)
    {
        return pengumpulanLkpd::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }

    public function storeEvent(Request $request)
    {
        // Validate the input
        $request->validate([
            'deskripsi_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
        ]);

        // Store the new event
        jadwalKegiatan::create([
            'user_id' => auth()->id(), // Ensure the user is authenticated
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ]);

        // Redirect back with a success message
        return redirect()->route('dashboard')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function markAttendance(Request $request)
    {
        $user = auth()->user();

        Kehadiran::create([
            'user_id' => $user->id,
            'status_kehadiran' => 'Hadir',
            'tanggal_masuk' => Carbon::today(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Kehadiran berhasil dicatat.');
    }
}
