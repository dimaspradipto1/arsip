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

    // SK Pengangkatan Struktural (Full CRUD for Dosen & other roles)
    Route::get('/skpengangkatanstruktural/template', [SkPengangkatanStrukturalController::class, 'downloadTemplate'])->name('skpengangkatanstruktural.template');
    Route::post('/skpengangkatanstruktural/import', [SkPengangkatanStrukturalController::class, 'import'])->name('skpengangkatanstruktural.import');
    Route::resource('skpengangkatanstruktural', SkPengangkatanStrukturalController::class);

    // Read routes accessible by all roles (including Dosen)
    Route::get('/identitaskaryailmiah', [IdentitasKaryaIlmiahController::class, 'index'])->name('identitaskaryailmiah.index');
    Route::get('/identitaskaryailmiah/template', [IdentitasKaryaIlmiahController::class, 'downloadTemplate'])->name('identitaskaryailmiah.template');
    Route::get('/identitaskaryailmiah/{identitaskaryailmiah}', [IdentitasKaryaIlmiahController::class, 'show'])->name('identitaskaryailmiah.show');

    Route::get('/skpengajaran', [SkPengajaranController::class, 'index'])->name('skpengajaran.index');
    Route::get('/skpengajaran/template', [SkPengajaranController::class, 'downloadTemplate'])->name('skpengajaran.template');
    Route::get('/skpengajaran/{skpengajaran}', [SkPengajaranController::class, 'show'])->name('skpengajaran.show');

    Route::get('/skpembimbingakademik', [SkPembimbingAkademikController::class, 'index'])->name('skpembimbingakademik.index');
    Route::get('/skpembimbingakademik/template', [SkPembimbingAkademikController::class, 'downloadTemplate'])->name('skpembimbingakademik.template');
    Route::get('/skpembimbingakademik/{skpembimbingakademik}', [SkPembimbingAkademikController::class, 'show'])->name('skpembimbingakademik.show');

    Route::get('/skpembimbingkpm', [SkPembimbingKpmController::class, 'index'])->name('skpembimbingkpm.index');
    Route::get('/skpembimbingkpm/template', [SkPembimbingKpmController::class, 'downloadTemplate'])->name('skpembimbingkpm.template');
    Route::get('/skpembimbingkpm/{skpembimbingkpm}', [SkPembimbingKpmController::class, 'show'])->name('skpembimbingkpm.show');

    Route::get('/skpembimbingtugasakhir', [SkPembimbingTugasAkhirController::class, 'index'])->name('skpembimbingtugasakhir.index');
    Route::get('/skpembimbingtugasakhir/template', [SkPembimbingTugasAkhirController::class, 'downloadTemplate'])->name('skpembimbingtugasakhir.template');
    Route::get('/skpembimbingtugasakhir/{skpembimbingtugasakhir}', [SkPembimbingTugasAkhirController::class, 'show'])->name('skpembimbingtugasakhir.show');

    Route::get('/skpengujisempro', [SkPengujiSemproController::class, 'index'])->name('skpengujisempro.index');
    Route::get('/skpengujisempro/template', [SkPengujiSemproController::class, 'downloadTemplate'])->name('skpengujisempro.template');
    Route::get('/skpengujisempro/{skpengujisempro}', [SkPengujiSemproController::class, 'show'])->name('skpengujisempro.show');

    Route::get('/skpengujitugasakhir', [SkPengujiTugasAkhirController::class, 'index'])->name('skpengujitugasakhir.index');
    Route::get('/skpengujitugasakhir/template', [SkPengujiTugasAkhirController::class, 'downloadTemplate'])->name('skpengujitugasakhir.template');
    Route::get('/skpengujitugasakhir/{skpengujitugasakhir}', [SkPengujiTugasAkhirController::class, 'show'])->name('skpengujitugasakhir.show');

    Route::get('/skkepanitiaan', [SkKepanitiaanController::class, 'index'])->name('skkepanitiaan.index');
    Route::get('/skkepanitiaan/{skkepanitiaan}', [SkKepanitiaanController::class, 'show'])->name('skkepanitiaan.show');

    Route::get('/tahunakademik', [TahunAkademikController::class, 'index'])->name('tahunakademik.index');
    Route::get('/tahunakademik/{tahunakademik}', [TahunAkademikController::class, 'show'])->name('tahunakademik.show');

    Route::get('/kategorysk', [KategorySkController::class, 'index'])->name('kategorysk.index');
    Route::get('/kategorysk/{kategorysk}', [KategorySkController::class, 'show'])->name('kategorysk.show');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/template', [UserController::class, 'downloadTemplate'])->name('user.template');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');

    // Write routes (Restricted from Dosen)
    Route::middleware('restrict.dosen')->group(function(){
        Route::post('/identitaskaryailmiah/import', [IdentitasKaryaIlmiahController::class, 'import'])->name('identitaskaryailmiah.import');
        Route::resource('identitaskaryailmiah', IdentitasKaryaIlmiahController::class)->except(['index', 'show']);

        Route::post('/skpengajaran/import', [SkPengajaranController::class, 'import'])->name('skpengajaran.import');
        Route::resource('skpengajaran', SkPengajaranController::class)->except(['index', 'show']);

        Route::post('/skpembimbingakademik/import', [SkPembimbingAkademikController::class, 'import'])->name('skpembimbingakademik.import');
        Route::resource('skpembimbingakademik', SkPembimbingAkademikController::class)->except(['index', 'show']);

        Route::post('/skpembimbingkpm/import', [SkPembimbingKpmController::class, 'import'])->name('skpembimbingkpm.import');
        Route::resource('skpembimbingkpm', SkPembimbingKpmController::class)->except(['index', 'show']);

        Route::post('/skpembimbingtugasakhir/import', [SkPembimbingTugasAkhirController::class, 'import'])->name('skpembimbingtugasakhir.import');
        Route::resource('skpembimbingtugasakhir', SkPembimbingTugasAkhirController::class)->except(['index', 'show']);

        Route::post('/skpengujisempro/import', [SkPengujiSemproController::class, 'import'])->name('skpengujisempro.import');
        Route::resource('skpengujisempro', SkPengujiSemproController::class)->except(['index', 'show']);

        Route::post('/skpengujitugasakhir/import', [SkPengujiTugasAkhirController::class, 'import'])->name('skpengujitugasakhir.import');
        Route::resource('skpengujitugasakhir', SkPengujiTugasAkhirController::class)->except(['index', 'show']);

        Route::resource('skkepanitiaan', SkKepanitiaanController::class)->except(['index', 'show']);
        Route::resource('tahunakademik', TahunAkademikController::class)->except(['index', 'show']);
        Route::resource('kategorysk', KategorySkController::class)->except(['index', 'show']);

        Route::post('/user/import', [UserController::class, 'import'])->name('user.import');
        Route::get('/user/{id}/update-password', [UserController::class, 'showUpdatePasswordForm'])->name('user.showUpdatePasswordForm');
        Route::post('/user/{id}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
        Route::resource('user', UserController::class)->except(['index', 'show']);
    });
});



