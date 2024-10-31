<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\authController;
use App\Http\Controllers\admin\kelolaAkunController;
use App\Http\Controllers\admin\kelolaCoursesController;
use App\Http\Controllers\guru\kelolaMateriController;
use App\Http\Controllers\guru\kelolaPostestController;
use App\Http\Controllers\guru\kelolaPretestController;
use App\Http\Controllers\guru\penilaianPretestController;
use App\Http\Controllers\siswa\coursesController;
use App\Http\Controllers\siswa\pretestController;


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
Route::get('kelolamateri', [kelolaMateriController::class, 'kelolamateri'])->name('kelolamateri');
Route::post('kelolamateri/store', [kelolaMateriController::class, 'store'])->name('storekelolamateri');
// Kelola Pretest
Route::get('kelolapretest', [kelolaPretestController::class, 'kelolapretest'])->name('kelolapretest');
Route::post('kelolapretest/store', [kelolaPretestController::class, 'store'])->name('storepretest');
Route::delete('kelolapretest/delete/{id}', [kelolaPretestController::class, 'delete'])->name('deletepretest');
// Penilaian Pretest
Route::get('penilaianpretest', [penilaianPretestController::class, 'penilaianpretest'])->name('penilaianpretest');
Route::get('lihatJawaban/{user_id}', [penilaianPretestController::class, 'lihatJawaban'])->name('lihatJawaban');
Route::post('store-score/{user_id}/{pretest_id}', [PenilaianPretestController::class, 'storeScore'])->name('storeScore');


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
