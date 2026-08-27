<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdentitasKaryaIlmiahController;
use App\Http\Controllers\KategorySkController;
use App\Http\Controllers\SkKepanitiaanController;
use App\Http\Controllers\SkPembimbingAkademikController;
use App\Http\Controllers\SkPembimbingKpmController;
use App\Http\Controllers\SkPembimbingTugasAkhirController;
use App\Http\Controllers\SkPengajaranController;
use App\Http\Controllers\SkPengangkatanStrukturalController;
use App\Http\Controllers\SkPengujiSemproController;
use App\Http\Controllers\SkPengujiTugasAkhirController;
use App\Http\Controllers\TahunAkademikController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/loginproses', 'loginproses')->name('loginproses');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware(['auth','checkrole'])->group(function(){
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/identitaskaryailmiah/template', [IdentitasKaryaIlmiahController::class, 'downloadTemplate'])->name('identitaskaryailmiah.template');
    Route::post('/identitaskaryailmiah/import', [IdentitasKaryaIlmiahController::class, 'import'])->name('identitaskaryailmiah.import');
    Route::resource('identitaskaryailmiah', IdentitasKaryaIlmiahController::class);
    Route::get('/user/template', [UserController::class, 'downloadTemplate'])->name('user.template');
    Route::post('/user/import', [UserController::class, 'import'])->name('user.import');
    Route::get('/user/{id}/update-password', [UserController::class, 'showUpdatePasswordForm'])->name('user.showUpdatePasswordForm');
    Route::post('/user/{id}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::resource('user', UserController::class);
    Route::resource('tahunakademik', TahunAkademikController::class);
    Route::resource('/kategorysk', KategorySkController::class);
    Route::resource('skkepanitiaan', SkKepanitiaanController::class);
    Route::get('/skpengajaran/template', [SkPengajaranController::class, 'downloadTemplate'])->name('skpengajaran.template');
    Route::post('/skpengajaran/import', [SkPengajaranController::class, 'import'])->name('skpengajaran.import');
    Route::resource('skpengajaran', SkPengajaranController::class);
    Route::get('/skpembimbingakademik/template', [SkPembimbingAkademikController::class, 'downloadTemplate'])->name('skpembimbingakademik.template');
    Route::post('/skpembimbingakademik/import', [SkPembimbingAkademikController::class, 'import'])->name('skpembimbingakademik.import');
    Route::resource('skpembimbingakademik', SkPembimbingAkademikController::class);
    Route::get('/skpembimbingkpm/template', [SkPembimbingKpmController::class, 'downloadTemplate'])->name('skpembimbingkpm.template');
    Route::post('/skpembimbingkpm/import', [SkPembimbingKpmController::class, 'import'])->name('skpembimbingkpm.import');
    Route::resource('skpembimbingkpm', SkPembimbingKpmController::class);
    Route::get('/skpembimbingtugasakhir/template', [SkPembimbingTugasAkhirController::class, 'downloadTemplate'])->name('skpembimbingtugasakhir.template');
    Route::post('/skpembimbingtugasakhir/import', [SkPembimbingTugasAkhirController::class, 'import'])->name('skpembimbingtugasakhir.import');
    Route::resource('skpembimbingtugasakhir', SkPembimbingTugasAkhirController::class);
    Route::get('/skpengangkatanstruktural/template', [SkPengangkatanStrukturalController::class, 'downloadTemplate'])->name('skpengangkatanstruktural.template');
    Route::post('/skpengangkatanstruktural/import', [SkPengangkatanStrukturalController::class, 'import'])->name('skpengangkatanstruktural.import');
    Route::resource('skpengangkatanstruktural', SkPengangkatanStrukturalController::class);
    Route::get('/skpengujisempro/template', [SkPengujiSemproController::class, 'downloadTemplate'])->name('skpengujisempro.template');
    Route::post('/skpengujisempro/import', [SkPengujiSemproController::class, 'import'])->name('skpengujisempro.import');
    Route::resource('skpengujisempro', SkPengujiSemproController::class);
    Route::get('/skpengujitugasakhir/template', [SkPengujiTugasAkhirController::class, 'downloadTemplate'])->name('skpengujitugasakhir.template');
    Route::post('/skpengujitugasakhir/import', [SkPengujiTugasAkhirController::class, 'import'])->name('skpengujitugasakhir.import');
    Route::resource('skpengujitugasakhir', SkPengujiTugasAkhirController::class);
});



