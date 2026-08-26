<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategorySkController;
use App\Http\Controllers\SkKepanitiaanController;
use App\Http\Controllers\SkPembimbingAkademikController;
use App\Http\Controllers\SkPembimbingKpmController;
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
    Route::get('/user/template', [UserController::class, 'downloadTemplate'])->name('user.template');
    Route::post('/user/import', [UserController::class, 'import'])->name('user.import');
    Route::get('/user/{id}/update-password', [UserController::class, 'showUpdatePasswordForm'])->name('user.showUpdatePasswordForm');
    Route::post('/user/{id}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::resource('user', UserController::class);
    Route::resource('tahunakademik', TahunAkademikController::class);
    Route::resource('/kategorysk', KategorySkController::class);
    Route::resource('skkepanitiaan', SkKepanitiaanController::class);
    Route::get('/skpembimbingakademik/template', [SkPembimbingAkademikController::class, 'downloadTemplate'])->name('skpembimbingakademik.template');
    Route::post('/skpembimbingakademik/import', [SkPembimbingAkademikController::class, 'import'])->name('skpembimbingakademik.import');
    Route::resource('skpembimbingakademik', SkPembimbingAkademikController::class);
    Route::get('/skpembimbingkpm/template', [SkPembimbingKpmController::class, 'downloadTemplate'])->name('skpembimbingkpm.template');
    Route::post('/skpembimbingkpm/import', [SkPembimbingKpmController::class, 'import'])->name('skpembimbingkpm.import');
    Route::resource('skpembimbingkpm', SkPembimbingKpmController::class);
});
