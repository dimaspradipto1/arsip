<?php

namespace App\Http\Controllers;

use App\Models\SkKepanitiaan;
use App\Models\SkPembimbingAkademik;
use App\Models\SkPembimbingKpm;
use App\Models\SkPembimbingTugasAkhir;
use App\Models\SkPengajaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $skPanitiaCount = SkKepanitiaan::query()->count();
        $skPaCount = SkPembimbingAkademik::query()->count();
        $skKpmCount = SkPembimbingKpm::query()->count();
        $skPengajaranCount = SkPengajaran::query()->count();
        $skTaCount = SkPembimbingTugasAkhir::query()->count();

        $bidang = [
            'BIDANG PENDIDIKAN' => [
                ['nama' => 'SK PENGAJARAN', 'count' => $skPengajaranCount],
                ['nama' => 'SK PEMBIMBING TUGAS AKHIR', 'count' => $skTaCount],
                ['nama' => 'SK PEMBIMBING DAN BERITA ACARA MAHASISWA SIDANG', 'count' => 0],
                ['nama' => 'SK PEMBIMBING DAN BERITA ACARA PENGUJI SEMINAR PROPOSAL', 'count' => 0],
                ['nama' => 'DOKUMEN GABUNGAN PENGUJI SIDANG (SK PENGUJI DAN BERITA ACARA PENGUJI)', 'count' => 0],
                ['nama' => 'SK PENGUJIAN MAHASISWA', 'count' => 0],
                ['nama' => 'SK DOSEN PEBIMBING KPM', 'count' => $skKpmCount],
                ['nama' => 'SK PEMBIMBING AKADEMIK (PA)', 'count' => $skPaCount],
            ],
            'BIDANG PENELITIAN' => [
                ['nama' => 'BUKU', 'count' => 0],
                ['nama' => 'HAKI', 'count' => 0],
                ['nama' => 'PENGELOLA JURNAL', 'count' => 0],
            ],
            'BIDANG PENGABDIAN' => [
                ['nama' => 'LAPORAN PENGABDIAN', 'count' => 0],
            ],
            'PENUNJANG' => [
                ['nama' => 'SK PANITIA', 'count' => $skPanitiaCount],
                ['nama' => 'SK ANGGOTA PROFESI', 'count' => 0],
                ['nama' => 'SK JABATAN STRUKTURAL', 'count' => 0],
            ],
        ];

        $bidangPendidikan = $bidang['BIDANG PENDIDIKAN'];
        $bidangPenelitian = $bidang['BIDANG PENELITIAN'];
        $bidangPengabdian = $bidang['BIDANG PENGABDIAN'];
        $penunjang = $bidang['PENUNJANG'];

        $totalDokumenPelaksanaan = collect($bidang)->flatten(1)->sum('count');

        $dokumenPendukung = [
            ['no' => 1, 'nama' => 'SK PENGANGKATAN KARYAWAN', 'count' => 0],
            ['no' => 3, 'nama' => 'IJAZAH & TRANSKRIP NILAI S1, S2, S3', 'count' => 0],
            ['no' => 4, 'nama' => 'KTA PNS', 'count' => 0],
            ['no' => 5, 'nama' => 'SK PENGANGKATAN DOSEN TETAP YAPISTA', 'count' => 0],
            ['no' => 6, 'nama' => 'SERTIFIKASI PENDIDIK (SERDOS)', 'count' => 0],
            ['no' => 7, 'nama' => 'SK PNS PENEMPATAN KOPERTIS', 'count' => 0],
            ['no' => 8, 'nama' => 'SK KEPALA BADAN KEPEGAWAIAN NEGARA', 'count' => 0],
            ['no' => 9, 'nama' => 'SK PNS', 'count' => 0],
            ['no' => 10, 'nama' => 'SK SENAT FAKULTAS', 'count' => 0],
            ['no' => 11, 'nama' => 'SKP 2021', 'count' => 0],
            ['no' => 12, 'nama' => 'SK LEKTOR KEPALA', 'count' => 0],
        ];

        $rekapPublikasi = [
            ['tahun' => 2024, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2023, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2022, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2021, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2020, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2019, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
        ];

        return view('layouts.dashboard.index', compact(
            'bidangPendidikan',
            'bidangPenelitian',
            'bidangPengabdian',
            'penunjang',
            'totalDokumenPelaksanaan',
            'dokumenPendukung',
            'rekapPublikasi'
        ));
    }
}
