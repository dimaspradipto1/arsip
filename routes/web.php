<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HKIController;
use App\Http\Controllers\LaporanPenelitianController;
use App\Http\Controllers\BebanKerjaDosenController;
use App\Http\Controllers\SemesterAntaraController;
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

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/loginproses', 'loginproses')->name('loginproses');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');

    // 1. SK Pengangkatan Struktural (Full CRUD for Dosen & other roles)
    Route::get('/skpengangkatanstruktural/template', [SkPengangkatanStrukturalController::class, 'downloadTemplate'])->name('skpengangkatanstruktural.template');
    Route::post('/skpengangkatanstruktural/import', [SkPengangkatanStrukturalController::class, 'import'])->name('skpengangkatanstruktural.import');
    Route::resource('skpengangkatanstruktural', SkPengangkatanStrukturalController::class);

    // 2. Identitas Karya Ilmiah
    Route::get('/identitaskaryailmiah/template', [IdentitasKaryaIlmiahController::class, 'downloadTemplate'])->name('identitaskaryailmiah.template');
    Route::post('/identitaskaryailmiah/import', [IdentitasKaryaIlmiahController::class, 'import'])->name('identitaskaryailmiah.import')->middleware('restrict.dosen');
    Route::resource('identitaskaryailmiah', IdentitasKaryaIlmiahController::class);

    // 3. SK Pengajaran
    Route::get('/skpengajaran/template', [SkPengajaranController::class, 'downloadTemplate'])->name('skpengajaran.template');
    Route::post('/skpengajaran/import', [SkPengajaranController::class, 'import'])->name('skpengajaran.import')->middleware('restrict.dosen');
    Route::resource('skpengajaran', SkPengajaranController::class);

    // 4. SK Pembimbing Akademik
    Route::get('/skpembimbingakademik/template', [SkPembimbingAkademikController::class, 'downloadTemplate'])->name('skpembimbingakademik.template');
    Route::post('/skpembimbingakademik/import', [SkPembimbingAkademikController::class, 'import'])->name('skpembimbingakademik.import')->middleware('restrict.dosen');
    Route::resource('skpembimbingakademik', SkPembimbingAkademikController::class);

    // 5. SK Pembimbing KPM
    Route::get('/skpembimbingkpm/template', [SkPembimbingKpmController::class, 'downloadTemplate'])->name('skpembimbingkpm.template');
    Route::post('/skpembimbingkpm/import', [SkPembimbingKpmController::class, 'import'])->name('skpembimbingkpm.import')->middleware('restrict.dosen');
    Route::resource('skpembimbingkpm', SkPembimbingKpmController::class);

    // 6. SK Pembimbing Tugas Akhir
    Route::get('/skpembimbingtugasakhir/template', [SkPembimbingTugasAkhirController::class, 'downloadTemplate'])->name('skpembimbingtugasakhir.template');
    Route::post('/skpembimbingtugasakhir/import', [SkPembimbingTugasAkhirController::class, 'import'])->name('skpembimbingtugasakhir.import')->middleware('restrict.dosen');
    Route::resource('skpembimbingtugasakhir', SkPembimbingTugasAkhirController::class);

    // 7. SK Penguji Sempro
    Route::get('/skpengujisempro/template', [SkPengujiSemproController::class, 'downloadTemplate'])->name('skpengujisempro.template');
    Route::post('/skpengujisempro/import', [SkPengujiSemproController::class, 'import'])->name('skpengujisempro.import')->middleware('restrict.dosen');
    Route::resource('skpengujisempro', SkPengujiSemproController::class);

    // 8. SK Penguji Tugas Akhir
    Route::get('/skpengujitugasakhir/template', [SkPengujiTugasAkhirController::class, 'downloadTemplate'])->name('skpengujitugasakhir.template');
    Route::post('/skpengujitugasakhir/import', [SkPengujiTugasAkhirController::class, 'import'])->name('skpengujitugasakhir.import')->middleware('restrict.dosen');
    Route::resource('skpengujitugasakhir', SkPengujiTugasAkhirController::class);

    // 9. SK Kepanitiaan
    Route::resource('skkepanitiaan', SkKepanitiaanController::class);

    // 10. Buku (Bidang Penelitian)
    Route::get('/buku/template', [BukuController::class, 'downloadTemplate'])->name('buku.template');
    Route::post('/buku/import', [BukuController::class, 'import'])->name('buku.import')->middleware('restrict.dosen');
    Route::resource('buku', BukuController::class);

    // 11. HKI (Bidang Penelitian)
    Route::get('/hki/template', [HKIController::class, 'downloadTemplate'])->name('hki.template');
    Route::post('/hki/import', [HKIController::class, 'import'])->name('hki.import')->middleware('restrict.dosen');
    Route::resource('hki', HKIController::class);

    // 12. Laporan Penelitian (Bidang Penelitian)
    Route::get('/laporanpenelitian/template', [LaporanPenelitianController::class, 'downloadTemplate'])->name('laporanpenelitian.template');
    Route::post('/laporanpenelitian/import', [LaporanPenelitianController::class, 'import'])->name('laporanpenelitian.import')->middleware('restrict.dosen');
    Route::resource('laporanpenelitian', LaporanPenelitianController::class);

    // 13. LPJ Beban Kerja Dosen (LPJ Kegiatan Panitia Semester)
    Route::get('/bebankerjadosen/template', [BebanKerjaDosenController::class, 'downloadTemplate'])->name('bebankerjadosen.template');
    Route::post('/bebankerjadosen/import', [BebanKerjaDosenController::class, 'import'])->name('bebankerjadosen.import')->middleware('restrict.dosen');
    Route::resource('bebankerjadosen', BebanKerjaDosenController::class);

    // 14. LPJ Semester Antara (LPJ Kegiatan Panitia Semester)
    Route::get('/semesterantara/template', [SemesterAntaraController::class, 'downloadTemplate'])->name('semesterantara.template');
    Route::post('/semesterantara/import', [SemesterAntaraController::class, 'import'])->name('semesterantara.import')->middleware('restrict.dosen');
    Route::resource('semesterantara', SemesterAntaraController::class);

    // 15. Master Data (Tahun Akademik & Kategori SK)
    Route::resource('tahunakademik', TahunAkademikController::class);
    Route::resource('kategorysk', KategorySkController::class);

    // 11. User Management
    Route::get('/user/template', [UserController::class, 'downloadTemplate'])->name('user.template');
    Route::post('/user/import', [UserController::class, 'import'])->name('user.import')->middleware('restrict.dosen');
    Route::get('/user/{id}/update-password', [UserController::class, 'showUpdatePasswordForm'])->name('user.showUpdatePasswordForm');
    Route::post('/user/{id}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::resource('user', UserController::class);
});
