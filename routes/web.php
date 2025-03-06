<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\authController;
use App\Http\Controllers\leaderboardController;
use App\Http\Controllers\admin\kelolaAkunController;
use App\Http\Controllers\admin\kelolaCoursesController;
use App\Http\Controllers\guru\kelolaMateriController;
use App\Http\Controllers\guru\kelolaPostestController;
use App\Http\Controllers\guru\kelolaPretestController;
use App\Http\Controllers\guru\penilaianLkpdController;
use App\Http\Controllers\guru\penilaianPretestController;
use App\Http\Controllers\guru\penilaianPostestController;
use App\Http\Controllers\guru\kelolaManualController;
use App\Http\Controllers\guru\kelolaKelompokController;
use App\Http\Controllers\siswa\coursesController;
use App\Http\Controllers\siswa\pretestController;
use App\Http\Controllers\siswa\PostestController;
use App\Http\Controllers\siswa\manualController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route General
Route::get('/', [authController::class, 'login'])->name('login');
Route::get('dashboard', [dashboardController::class, 'dashboard'])->name('dashboard');
Route::post('store-event', [dashboardController::class, 'storeEvent'])->name('storeEvent');
Route::post('/mark-attendance', [dashboardController::class, 'markAttendance'])->name('markAttendance');

Route::post('login', [authController::class, 'authenticate'])->name('authenticate');
Route::get('logout', [authController::class, 'logout'])->name('logout');
Route::get('leaderboard', [leaderboardController::class, 'leaderboard'])->name('leaderboard');

// Route Admin
// Kelola Akun
Route::get('kelolaakun', [kelolaAkunController::class, 'kelolaakun'])->name('kelolaakun');
Route::post('kelolaakun/update/{id}', [kelolaAkunController::class, 'update'])->name('updateakun');
Route::post('kelolaakun/changepassword/{id}', [kelolaAkunController::class, 'changePassword'])->name('changepasswordakun');
Route::delete('kelolaakun/delete/{id}', [kelolaAkunController::class, 'delete'])->name('deleteakun');
Route::post('kelolaakun/store', [kelolaAkunController::class, 'store'])->name('storeakun');

// Kelola Courses
Route::get('kelolacourses', [kelolaCoursesController::class, 'kelolacourses'])->name('kelolacourses');
Route::post('kelolacourses/store', [kelolaCoursesController::class, 'store'])->name('storecourse');
Route::post('kelolacourses/update/{id}', [kelolaCoursesController::class, 'update'])->name('updatecourse');
Route::delete('kelolacourses/delete/{id}', [kelolaCoursesController::class, 'delete'])->name('deletecourse');

// Route Guru
// Kelola Kelompok
Route::get('kelolakelompok', [kelolaKelompokController::class, 'kelolakelompok'])->name('kelolakelompok'); // Menampilkan halaman kelola kelompok
Route::post('kelolakelompok/store', [kelolaKelompokController::class, 'store'])->name('kelolakelompok.store'); // Menampilkan halaman kelola kelompok
Route::get('kelolakelompok/{kelompok}/edit', [kelolaKelompokController::class, 'edit'])->name('kelolakelompok.edit'); // Menampilkan modal edit kelompok
Route::put('kelolakelompok/{kelompok}', [kelolaKelompokController::class, 'update'])->name('kelolakelompok.update'); // Menyimpan perubahan kelompok
Route::delete('kelolakelompok/{kelompok}', [kelolaKelompokController::class, 'destroy'])->name('kelolakelompok.destroy'); // Menghapus kelompok

// Kelola Materi
Route::get('kelolamateri', [kelolaMateriController::class, 'kelolaMateri'])->name('kelolamateri');
Route::get('kelolamateri/{course_id}', [kelolaMateriController::class, 'showKelolaMateri'])->name('showkelolamateri');
Route::post('kelolamateri/store', [kelolaMateriController::class, 'store'])->name('storekelolamateri');
Route::post('kelolamateri/storelkpdkelompok', [kelolaMateriController::class, 'storelkpdkelompok'])->name('storelkpdkelompok');
Route::delete('kelolamateri/deletelkpdkelompok/{id}', [kelolaMateriController::class, 'deletelkpdkelompok'])->name('deletelkpdkelompok');
Route::put('kelolamateri/updatelkpdkelompok', [kelolaMateriController::class, 'updatelkpdkelompok'])->name('updatelkpdkelompok');
// Penilaian LKPD
Route::get('penilaianlkpd', [penilaianLkpdController::class, 'pilihLkpd'])->name('penilaianlkpd');
Route::get('penilaianlkpd/{course_id}', [penilaianLkpdController::class, 'penilaianLkpd'])->name('pilihLkpd');
Route::post('penilaianlkpd/simpan', [penilaianLkpdController::class, 'simpanNilai'])->name('simpanNilaiLkpd');
// Penilaian LKPDKelompok
Route::get('penilaianlkpdKelompok', [penilaianLkpdController::class, 'pilihLkpdKelompok'])->name('penilaianlkpdkelompok');
Route::get('penilaianlkpdkelompok/{course_id}', [penilaianLkpdController::class, 'penilaianLkpdKelompok'])->name('pilihLkpdKelompok');
// Kelola Pretest
Route::get('kelolapretest', [kelolaPretestController::class, 'kelolapretest'])->name('kelolapretest');
Route::post('kelolapretest/store', [kelolaPretestController::class, 'store'])->name('storepretest');
Route::delete('kelolapretest/delete/{id}/{type}', [kelolaPretestController::class, 'delete'])->name('deletepretest');
Route::put('kelolapretest/update', [kelolaPretestController::class, 'update'])->name('updatepretest');

// Penilaian Pretest
Route::get('penilaianpretest', [penilaianPretestController::class, 'penilaianpretest'])->name('penilaianpretest');
Route::get('lihatJawaban/{user_id}', [penilaianPretestController::class, 'lihatJawaban'])->name('lihatJawaban');
Route::post('penilaianpretest/{user_id}/simpan-nilai', [penilaianPretestController::class, 'storeScore'])->name('storeScorePretest');
// Kelola Postest
Route::get('kelolapostest', [kelolaPostestController::class, 'kelolapostest'])->name('kelolapostest');
Route::post('kelolapostest/store', [kelolaPostestController::class, 'store'])->name('storepostest');
Route::delete('kelolapostest/delete/{id}/{type}', [kelolaPostestController::class, 'delete'])->name('deletepostest');
// Penilaian Postest
Route::get('penilaianpostest', [penilaianPostestController::class, 'penilaianpostest'])->name('penilaianpostest');
Route::get('lihatJawabanPostest/{user_id}', [penilaianPostestController::class, 'lihatJawabanPostest'])->name('lihatJawabanPostest');
Route::post('penilaianpostest/{user_id}/simpan-nilai', [penilaianPostestController::class, 'storeScore'])->name('storeScorePostest');
Route::put('kelolapostest/update', [kelolaPostestController::class, 'update'])->name('updatepostest');
// Kelola Manual Book
Route::get('kelolamanualbook', [kelolaManualController::class, 'kelolaManual'])->name('kelolamanualbook');
Route::post('kelolamanualbook/store', [kelolaManualController::class, 'store'])->name('storekelolamanualbook');

// Route Siswa
// Courses
// Route::get('course', [coursesController::class, 'course'])->name('course');
Route::get('course/{id}', [coursesController::class, 'course'])->name('course');
Route::get('modul/{id}', [coursesController::class, 'showModul'])->name('showModul');
Route::get('ppt/{id}', [coursesController::class, 'showPpt'])->name('showPpt');
Route::get('lkpd/{id}', [coursesController::class, 'showLkpd'])->name('showLkpd');
Route::get('pengumpulanlkpd/{id}', [coursesController::class, 'pengumpulanLkpd'])->name('pengumpulanLkpd');
Route::post('storePengumpulanLkpd', [coursesController::class, 'storePengumpulanLkpd'])->name('storePengumpulanLkpd');
Route::get('lkpdkelompokquestions/{id}', [coursesController::class, 'lkpdkelompokquestions'])->name('lkpdkelompokquestions');
Route::post('storeAnswersLkpdKelompok', [coursesController::class, 'storeAnswersLkpd'])->name('storeAnswersLkpdKelompok');
Route::post('storePembagianTugas', [coursesController::class, 'storePembagianTugas'])->name('storePembagianTugas');


// Pretest
Route::get('pretest', [pretestController::class, 'pretest'])->name('pretest');
Route::get('showpretestquestion', [PretestController::class, 'showPretestQuestions'])->name('showPretestQuestions');
Route::post('storeAnswers', [PretestController::class, 'storeAnswers'])->name('storeAnswers');

// postest
Route::get('postest', [PostestController::class, 'postest'])->name('postest');
Route::get('showpostestquestion', [PostestController::class, 'showpostestQuestions'])->name('showpostestQuestions');
Route::post('storeAnswersPostest', [PostestController::class, 'storeAnswers'])->name('storeAnswersPostest');

// Manual Book
Route::get('manualbook', [coursesController::class, 'manualBook'])->name('manualbook');
