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
use App\Http\Controllers\guru\penilaianPretestController;
use App\Http\Controllers\guru\penilaianPostestController;
use App\Http\Controllers\siswa\coursesController;
use App\Http\Controllers\siswa\pretestController;
use App\Http\Controllers\siswa\PostestController;


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
// Kelola Materi
Route::get('kelolamateri', [kelolaMateriController::class, 'kelolaMateri'])->name('kelolamateri');
Route::get('kelolamateri/{course_id}', [kelolaMateriController::class, 'showKelolaMateri'])->name('showkelolamateri');
Route::post('kelolamateri/store', [kelolaMateriController::class, 'store'])->name('storekelolamateri');

// Kelola Pretest
Route::get('kelolapretest', [kelolaPretestController::class, 'kelolapretest'])->name('kelolapretest');
Route::post('kelolapretest/store', [kelolaPretestController::class, 'store'])->name('storepretest');
Route::delete('kelolapretest/delete/{id}', [kelolaPretestController::class, 'delete'])->name('deletepretest');
// Penilaian Pretest
Route::get('penilaianpretest', [penilaianPretestController::class, 'penilaianpretest'])->name('penilaianpretest');
Route::get('lihatJawaban/{user_id}', [penilaianPretestController::class, 'lihatJawaban'])->name('lihatJawaban');
Route::post('penilaianpretest/{user_id}/simpan-nilai', [penilaianPretestController::class, 'storeScore'])->name('storeScorePretest');
// Kelola Postest
Route::get('kelolapostest', [kelolaPostestController::class, 'kelolapostest'])->name('kelolapostest');
Route::post('kelolapostest/store', [kelolaPostestController::class, 'store'])->name('storepostest');
Route::delete('kelolapostest/delete/{id}', [kelolaPostestController::class, 'delete'])->name('deletepostest');
// Penilaian Postest
Route::get('penilaianpostest', [penilaianPostestController::class, 'penilaianpostest'])->name('penilaianpostest');
Route::get('lihatJawabanPostest/{user_id}', [penilaianPostestController::class, 'lihatJawabanPostest'])->name('lihatJawabanPostest');
Route::post('penilaianpostest/{user_id}/simpan-nilai', [penilaianPostestController::class, 'storeScore'])->name('storeScorePostest');

// Route Siswa
// Courses
// Route::get('course', [coursesController::class, 'course'])->name('course');
Route::get('course/{id}', [coursesController::class, 'course'])->name('course');
Route::get('modul/{id}', [coursesController::class, 'showModul'])->name('showModul');
Route::get('ppt/{id}', [coursesController::class, 'showPpt'])->name('showPpt');
Route::get('lkpd/{id}', [coursesController::class, 'showLkpd'])->name('showLkpd');

// Pretest
Route::get('pretest', [pretestController::class, 'pretest'])->name('pretest');
Route::get('showpretestquestion', [PretestController::class, 'showPretestQuestions'])->name('showPretestQuestions');
Route::post('storeAnswers', [PretestController::class, 'storeAnswers'])->name('storeAnswers');

// postest
Route::get('postest', [PostestController::class, 'postest'])->name('postest');
Route::get('showpostestquestion', [PostestController::class, 'showpostestQuestions'])->name('showpostestQuestions');
Route::post('storeAnswers', [PostestController::class, 'storeAnswers'])->name('storeAnswers');
