<?php

namespace App\Http\Controllers;

use App\Models\SkKepanitiaan;
use App\Models\SkPembimbingAkademik;
use App\Models\SkPembimbingKpm;
use App\Models\SkPembimbingTugasAkhir;
use App\Models\SkPengajaran;
use App\Models\SkPengangkatanStruktural;
use App\Models\SkPengujiSempro;
use App\Models\SkPengujiTugasAkhir;
use App\Models\IdentitasKaryaIlmiah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;

        $isPureDosen = $user && $user->isOnlyDosen();
        $isDosen = $isPureDosen;
        $hasDosenRole = $user && $user->hasRole('dosen');
        $isDekan = $user && $user->hasRole('dekan');
        $isWd1 = $user && $user->hasRole('wakilDekan1');
        $isWd2 = $user && $user->hasRole('wakilDekan2');
        $isKaprodi = $user && $user->hasRole('kaprodi');
        $isSekprodi = $user && $user->hasRole('sekprodi');
        $isTataUsaha = $user && $user->hasRole('tatausaha');
        $isAdmin = $user && $user->hasRole('admin');
        $isLeadership = ($isDekan || $isWd1 || $isWd2 || $isKaprodi || $isSekprodi || $isTataUsaha || $isAdmin);

        // ==========================================
        // 1. DATA PRIBADI DOSEN (Personal Data)
        // ==========================================
        $personalSkPengajaran = SkPengajaran::where('user_id', $userId)->count();
        $personalSkTa = SkPembimbingTugasAkhir::where('user_id', $userId)->count();
        $personalSkSempro = SkPengujiSempro::whereHas('users', fn($q) => $q->where('users.id', $userId))->count();
        $personalSkPengujiTa = SkPengujiTugasAkhir::whereHas('users', fn($q) => $q->where('users.id', $userId))->count();
        $personalSkPa = SkPembimbingAkademik::where('user_id', $userId)->count();
        $personalSkKpm = SkPembimbingKpm::whereHas('users', fn($q) => $q->where('users.id', $userId))->count();
        $personalSkStruktural = SkPengangkatanStruktural::where('user_id', $userId)->count();
        $personalBuku = \App\Models\Buku::where('user_id', $userId)->count();
        $personalHki = \App\Models\HKI::where('user_id', $userId)->count();
        $personalLaporan = \App\Models\LaporanPenelitian::where('user_id', $userId)->count();

        // ==========================================
        // 2. DATA INSTITUSI / WEWENANG (Executive / Scoped Data)
        // ==========================================
        if ($isPureDosen) {
            $skPanitiaCount = 0;
            $skPaCount = $personalSkPa;
            $skKpmCount = $personalSkKpm;
            $skPengajaranCount = $personalSkPengajaran;
            $skTaCount = $personalSkTa;
            $skStrukturalCount = $personalSkStruktural;
            $skSemproCount = $personalSkSempro;
            $skPengujiTaCount = $personalSkPengujiTa;
            $totalDosen = 1;
            $prodiBreakdown = collect();
        } elseif ($isKaprodi || $isSekprodi && !$isDekan && !$isWd1 && !$isWd2 && !$isAdmin && !$isTataUsaha) {
            // Kaprodi / Sekprodi: Scoped specifically to their Program Studi (homebase)
            $skPanitiaCount = SkKepanitiaan::count();
            $skPaCount = SkPembimbingAkademik::whereHas('user', fn($q) => $q->prodiScope($user))->count();
            $skKpmCount = SkPembimbingKpm::whereHas('users', fn($q) => $q->prodiScope($user))->count();
            $skPengajaranCount = SkPengajaran::whereHas('user', fn($q) => $q->prodiScope($user))->count();
            $skTaCount = SkPembimbingTugasAkhir::whereHas('user', fn($q) => $q->prodiScope($user))->count();
            $skStrukturalCount = SkPengangkatanStruktural::whereHas('user', fn($q) => $q->prodiScope($user))->count();
            $skSemproCount = SkPengujiSempro::whereHas('users', fn($q) => $q->prodiScope($user))->count();
            $skPengujiTaCount = SkPengujiTugasAkhir::whereHas('users', fn($q) => $q->prodiScope($user))->count();
            $totalDosen = User::whereRole('dosen')->prodiScope($user)->count();

            $prodiBreakdown = User::whereRole('dosen')->prodiScope($user)
                ->select('homebase', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('homebase')
                ->get();
        } elseif (!$isAdmin) {
            // Dekan / Wakil Dekan 1 / Wakil Dekan 2 / TU: Scoped strictly to Faculty
            $skPanitiaCount = SkKepanitiaan::count();
            $skPaCount = SkPembimbingAkademik::whereHas('user', fn($q) => $q->facultyScope($user))->count();
            $skKpmCount = SkPembimbingKpm::whereHas('users', fn($q) => $q->facultyScope($user))->count();
            $skPengajaranCount = SkPengajaran::whereHas('user', fn($q) => $q->facultyScope($user))->count();
            $skTaCount = SkPembimbingTugasAkhir::whereHas('user', fn($q) => $q->facultyScope($user))->count();
            $skStrukturalCount = SkPengangkatanStruktural::whereHas('user', fn($q) => $q->facultyScope($user))->count();
            $skSemproCount = SkPengujiSempro::whereHas('users', fn($q) => $q->facultyScope($user))->count();
            $skPengujiTaCount = SkPengujiTugasAkhir::whereHas('users', fn($q) => $q->facultyScope($user))->count();
            $totalDosen = User::whereRole('dosen')->facultyScope($user)->count();

            $prodiBreakdown = User::whereRole('dosen')->facultyScope($user)
                ->select('homebase', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('homebase')
                ->orderByDesc('total')
                ->get();
        } else {
            // Admin sees global university data
            $skPanitiaCount = SkKepanitiaan::count();
            $skPaCount = SkPembimbingAkademik::count();
            $skKpmCount = SkPembimbingKpm::count();
            $skPengajaranCount = SkPengajaran::count();
            $skTaCount = SkPembimbingTugasAkhir::count();
            $skStrukturalCount = SkPengangkatanStruktural::count();
            $skSemproCount = SkPengujiSempro::count();
            $skPengujiTaCount = SkPengujiTugasAkhir::count();
            $totalDosen = User::whereRole('dosen')->count();

            $prodiBreakdown = User::whereRole('dosen')
                ->select('homebase', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('homebase')
                ->orderByDesc('total')
                ->get();
        }

        $bidang = [
            'BIDANG PENDIDIKAN' => [
                ['nama' => 'SK PENGAJARAN', 'count' => $skPengajaranCount, 'route' => route('skpengajaran.index')],
                ['nama' => 'SK PEMBIMBING TUGAS AKHIR', 'count' => $skTaCount, 'route' => route('skpembimbingtugasakhir.index')],
                ['nama' => 'SK PEMBIMBING DAN BERITA ACARA MAHASISWA SIDANG', 'count' => 0, 'route' => null],
                ['nama' => 'SK PENGUJI SEMINAR PROPOSAL', 'count' => $skSemproCount, 'route' => route('skpengujisempro.index')],
                ['nama' => 'SK PENGUJI SIDANG TUGAS AKHIR', 'count' => $skPengujiTaCount, 'route' => route('skpengujitugasakhir.index')],
                ['nama' => 'SK DOSEN PEMBIMBING KPM', 'count' => $skKpmCount, 'route' => route('skpembimbingkpm.index')],
                ['nama' => 'SK PEMBIMBING AKADEMIK (PA)', 'count' => $skPaCount, 'route' => route('skpembimbingakademik.index')],
            ],
            'BIDANG PENELITIAN' => [
                ['nama' => 'BUKU', 'count' => 0, 'route' => null],
                ['nama' => 'HAKI', 'count' => 0, 'route' => null],
                ['nama' => 'PENGELOLA JURNAL', 'count' => 0, 'route' => null],
            ],
            'BIDANG PENGABDIAN' => [
                ['nama' => 'LAPORAN PENGABDIAN', 'count' => 0, 'route' => null],
            ],
            'PENUNJANG' => [
                ['nama' => 'SK PANITIA', 'count' => $skPanitiaCount, 'route' => route('skkepanitiaan.index')],
                ['nama' => 'SK ANGGOTA PROFESI', 'count' => 0, 'route' => null],
                ['nama' => 'SK JABATAN STRUKTURAL', 'count' => $skStrukturalCount, 'route' => route('skpengangkatanstruktural.index')],
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

        $karyaIlmiahData = IdentitasKaryaIlmiah::latest()->get();
        $totalKaryaIlmiah = IdentitasKaryaIlmiah::count();
        $karyaIlmiahRecent = IdentitasKaryaIlmiah::latest()->take(5)->get();
        $kategoriSkList = \App\Models\KategorySk::withCount('skkepanitiaan')->get();

        // Recent SK Activity for Admin / Dekanat / Kaprodi / TU
        $recentSks = collect();
        if (!$isPureDosen) {
            $pengajaranLatest = SkPengajaran::with(['user', 'tahunakademik'])
                ->when($user && !$user->hasRole('admin'), function($query) use ($user) {
                    $query->whereHas('user', fn($q) => $q->accessScope($user));
                })
                ->latest()->take(3)->get()->map(function($item) {
                return [
                    'type' => 'SK Pengajaran',
                    'badge_bg' => 'bg-primary text-white',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'nomor_sk' => $item->nomor_sk,
                    'dosen' => $item->user ? $item->user->name : '-',
                    'tahun' => $item->tahunakademik ? $item->tahunakademik->tahun_akademik : '-',
                    'created_at' => $item->created_at,
                    'route' => route('skpengajaran.index'),
                    'dokumen' => $item->dokumen,
                ];
            });

            $taLatest = SkPembimbingTugasAkhir::with(['user', 'tahunakademik'])
                ->when($user && !$user->hasRole('admin'), function($query) use ($user) {
                    $query->whereHas('user', fn($q) => $q->accessScope($user));
                })
                ->latest()->take(3)->get()->map(function($item) {
                return [
                    'type' => 'SK Pembimbing TA',
                    'badge_bg' => 'bg-info text-white',
                    'icon' => 'fas fa-user-graduate',
                    'nomor_sk' => $item->nomor_sk,
                    'dosen' => ($item->user ? $item->user->name : '-') . ' (Mhs: ' . ($item->nama_mahasiswa ?? '-') . ')',
                    'tahun' => $item->tahunakademik ? $item->tahunakademik->tahun_akademik : '-',
                    'created_at' => $item->created_at,
                    'route' => route('skpembimbingtugasakhir.index'),
                    'dokumen' => $item->dokumen,
                ];
            });

            $semproLatest = SkPengujiSempro::with(['users', 'tahunakademik'])
                ->when($user && !$user->hasRole('admin'), function($query) use ($user) {
                    $query->whereHas('users', fn($q) => $q->accessScope($user));
                })
                ->latest()->take(3)->get()->map(function($item) {
                return [
                    'type' => 'SK Penguji Sempro',
                    'badge_bg' => 'bg-warning text-white',
                    'icon' => 'fas fa-clipboard-check',
                    'nomor_sk' => $item->nomor_sk,
                    'dosen' => $item->users->pluck('name')->implode(', ') ?: '-',
                    'tahun' => $item->tahunakademik ? $item->tahunakademik->tahun_akademik : '-',
                    'created_at' => $item->created_at,
                    'route' => route('skpengujisempro.index'),
                    'dokumen' => $item->dokumen,
                ];
            });

            $recentSks = $pengajaranLatest->concat($taLatest)->concat($semproLatest)->sortByDesc('created_at')->take(6)->values();
        }

        // Chart Data for Admin/TU/Dekanat/Kaprodi
        $chartSkLabels = ['Pengajaran', 'Pembimbing TA', 'Penguji Sempro', 'Penguji TA', 'Bimbingan KPM', 'Bimbingan PA', 'Struktural', 'Kepanitiaan'];
        $chartSkData = [$skPengajaranCount, $skTaCount, $skSemproCount, $skPengujiTaCount, $skKpmCount, $skPaCount, $skStrukturalCount, $skPanitiaCount];

        $rekapPublikasi = [
            ['tahun' => 2026, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2025, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2024, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2023, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2022, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
            ['tahun' => 2021, 'jntt' => 0, 'jnt' => 0, 'jt' => 0],
        ];

        return view('layouts.dashboard.index', compact(
            'isPureDosen',
            'isDosen',
            'isDekan',
            'isWd1',
            'isWd2',
            'isKaprodi',
            'isSekprodi',
            'isTataUsaha',
            'isAdmin',
            'isLeadership',
            'hasDosenRole',
            'personalSkPengajaran',
            'personalSkTa',
            'personalSkSempro',
            'personalSkPengujiTa',
            'personalSkPa',
            'personalSkKpm',
            'personalSkStruktural',
            'personalBuku',
            'personalHki',
            'personalLaporan',
            'skPanitiaCount',
            'skPaCount',
            'skKpmCount',
            'skPengajaranCount',
            'skTaCount',
            'skStrukturalCount',
            'skSemproCount',
            'skPengujiTaCount',
            'totalDosen',
            'prodiBreakdown',
            'bidangPendidikan',
            'bidangPenelitian',
            'bidangPengabdian',
            'penunjang',
            'totalDokumenPelaksanaan',
            'dokumenPendukung',
            'karyaIlmiahData',
            'totalKaryaIlmiah',
            'karyaIlmiahRecent',
            'kategoriSkList',
            'rekapPublikasi',
            'recentSks',
            'chartSkLabels',
            'chartSkData'
        ));
    }
}
