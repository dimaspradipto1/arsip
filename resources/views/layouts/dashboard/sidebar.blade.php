<style>
    #sidenav-collapse-main {
        display: block;
    }
    .sidenav .nav-link {
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
        font-weight: 600;
        font-size: 0.8125rem;
    }
    .sidenav .nav-link:hover {
        background-color: rgba(4, 107, 38, 0.08);
    }
    .sidenav .nav-link.active {
        background: #046B26 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(4, 107, 38, 0.25);
    }
    .sidenav .nav-link.active .icon {
        background: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
    }
    .sidenav .nav-link.active .nav-link-text {
        color: #ffffff !important;
        font-weight: 700;
    }
    .sidebar-dropdown-arrow {
        transition: transform 0.25s ease;
        font-size: 0.75rem;
    }
    .nav-link[aria-expanded="true"] .sidebar-dropdown-arrow {
        transform: rotate(180deg);
    }
    .sidebar-submenu {
        padding-left: 1.75rem;
        margin-top: 0.25rem;
        list-style: none;
    }
    .sidebar-submenu .nav-link {
        font-size: 0.775rem !important;
        font-weight: 500;
        padding: 0.45rem 0.75rem !important;
        color: #64748b !important;
        display: flex;
        align-items: center;
        border-radius: 6px;
    }
    .sidebar-submenu .nav-link:hover {
        color: #046B26 !important;
        background: rgba(4, 107, 38, 0.06);
    }
    .sidebar-submenu .nav-link.active {
        background: rgba(4, 107, 38, 0.12) !important;
        color: #046B26 !important;
        font-weight: 700 !important;
        box-shadow: none !important;
    }
    .sidebar-submenu .nav-link.active .sub-bullet {
        background-color: #046B26 !important;
        transform: scale(1.3);
    }
    .sub-bullet {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #94a3b8;
        display: inline-block;
        margin-right: 10px;
        transition: all 0.2s ease;
    }
</style>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
    <div class="sidenav-header position-relative">
        <i class="fas fa-times p-3 cursor-pointer text-secondary position-absolute end-0 top-0 d-xl-none fs-6"
            aria-hidden="true" id="iconSidenav" style="z-index: 100;" title="Tutup Menu"></i>
        <a class="navbar-brand m-0 d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('dashboard/assets/img/uis.png') }}" class="navbar-brand-img h-100 me-2" alt="main_logo">
            <span class="font-weight-bold text-dark text-uppercase" style="font-size: 0.95rem; letter-spacing: 0.5px;">E-Arsip UIS</span>
        </a>
    </div>
    
    <hr class="horizontal dark mt-0">

    <div class="collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- 1. Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="icon icon-shape icon-sm shadow-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        style="{{ request()->routeIs('dashboard') ? 'background: rgba(255,255,255,0.2); color: white;' : 'background: #ffffff; color: #046B26;' }}">
                        <i class="fas fa-chart-pie" style="font-size: 13px;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- 2. Identitas Karya Ilmiah -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('identitaskaryailmiah*') ? 'active' : '' }}" href="{{ route('identitaskaryailmiah.index') }}">
                    <div class="icon icon-shape icon-sm shadow-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        style="{{ request()->routeIs('identitaskaryailmiah*') ? 'background: rgba(255,255,255,0.2); color: white;' : 'background: #ffffff; color: #046B26;' }}">
                        <i class="fas fa-book-open" style="font-size: 13px;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Identitas Karya Ilmiah</span>
                </a>
            </li>

            <!-- 3. Bidang Pendidikan (Dropdown) -->
            @php
                $isPendidikanActive = request()->routeIs(
                    'skpengajaran*',
                    'skpembimbingakademik*',
                    'skpembimbingkpm*',
                    'skpembimbingtugasakhir*',
                    'skpengujisempro*',
                    'skpengujitugasakhir*'
                );
            @endphp
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between {{ $isPendidikanActive ? 'bg-light text-dark' : '' }}" 
                   data-bs-toggle="collapse" 
                   href="#collapsePendidikan" 
                   role="button" 
                   aria-expanded="{{ $isPendidikanActive ? 'true' : 'false' }}" 
                   aria-controls="collapsePendidikan">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm shadow-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center bg-white" style="color: #046B26;">
                            <i class="fas fa-graduation-cap" style="font-size: 13px;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Bidang Pendidikan</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow text-secondary ms-auto"></i>
                </a>
                <div class="collapse {{ $isPendidikanActive ? 'show' : '' }}" id="collapsePendidikan">
                    <ul class="sidebar-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpengajaran*') ? 'active' : '' }}" href="{{ route('skpengajaran.index') }}">
                                <span class="sub-bullet"></span> SK Pengajaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpembimbingakademik*') ? 'active' : '' }}" href="{{ route('skpembimbingakademik.index') }}">
                                <span class="sub-bullet"></span> SK Pembimbing Akademik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpembimbingkpm*') ? 'active' : '' }}" href="{{ route('skpembimbingkpm.index') }}">
                                <span class="sub-bullet"></span> SK Pembimbing KPM
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpembimbingtugasakhir*') ? 'active' : '' }}" href="{{ route('skpembimbingtugasakhir.index') }}">
                                <span class="sub-bullet"></span> SK Pembimbing Tugas Akhir
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpengujisempro*') ? 'active' : '' }}" href="{{ route('skpengujisempro.index') }}">
                                <span class="sub-bullet"></span> SK Penguji Sempro
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpengujitugasakhir*') ? 'active' : '' }}" href="{{ route('skpengujitugasakhir.index') }}">
                                <span class="sub-bullet"></span> SK Penguji Tugas Akhir
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- 4. Bidang Penelitian (Dropdown) -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between" 
                   data-bs-toggle="collapse" 
                   href="#collapsePenelitian" 
                   role="button" 
                   aria-expanded="false" 
                   aria-controls="collapsePenelitian">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm shadow-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center bg-white" style="color: #046B26;">
                            <i class="fas fa-flask" style="font-size: 13px;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Bidang Penelitian</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow text-secondary ms-auto"></i>
                </a>
                <div class="collapse" id="collapsePenelitian">
                    <ul class="sidebar-submenu">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> HAKI
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> Pengelola Jurnal
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- 5. Bidang Pengabdian (Dropdown) -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between" 
                   data-bs-toggle="collapse" 
                   href="#collapsePengabdian" 
                   role="button" 
                   aria-expanded="false" 
                   aria-controls="collapsePengabdian">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm shadow-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center bg-white" style="color: #046B26;">
                            <i class="fas fa-hands-helping" style="font-size: 13px;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Bidang Pengabdian</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow text-secondary ms-auto"></i>
                </a>
                <div class="collapse" id="collapsePengabdian">
                    <ul class="sidebar-submenu">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> Laporan Pengabdian
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- 6. Penunjang (Dropdown) -->
            @php
                $isPenunjangActive = request()->routeIs('skkepanitiaan*', 'skpengangkatanstruktural*');
            @endphp
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between {{ $isPenunjangActive ? 'bg-light text-dark' : '' }}" 
                   data-bs-toggle="collapse" 
                   href="#collapsePenunjang" 
                   role="button" 
                   aria-expanded="{{ $isPenunjangActive ? 'true' : 'false' }}" 
                   aria-controls="collapsePenunjang">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm shadow-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center bg-white" style="color: #046B26;">
                            <i class="fas fa-award" style="font-size: 13px;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Penunjang</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow text-secondary ms-auto"></i>
                </a>
                <div class="collapse {{ $isPenunjangActive ? 'show' : '' }}" id="collapsePenunjang">
                    <ul class="sidebar-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skkepanitiaan*') ? 'active' : '' }}" href="{{ route('skkepanitiaan.index') }}">
                                <span class="sub-bullet"></span> SK Panitia / Kepanitiaan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> SK Anggota Profesi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpengangkatanstruktural*') ? 'active' : '' }}" href="{{ route('skpengangkatanstruktural.index') }}">
                                <span class="sub-bullet"></span> SK Jabatan Struktural
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- 7. LPJ Kegiatan Panitia Tahunan (Dropdown) -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between" 
                   data-bs-toggle="collapse" 
                   href="#collapseLPJ" 
                   role="button" 
                   aria-expanded="false" 
                   aria-controls="collapseLPJ">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm shadow-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center bg-white" style="color: #046B26;">
                            <i class="fas fa-clipboard-check" style="font-size: 13px;"></i>
                        </div>
                        <span class="nav-link-text ms-1">LPJ Kegiatan Panitia</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow text-secondary ms-auto"></i>
                </a>
                <div class="collapse" id="collapseLPJ">
                    <ul class="sidebar-submenu">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> Audit Mutu Internal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> Pendidikan Karakter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> PMB
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> Milad
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> Wisuda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sub-bullet"></span> LPPM
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- 8. Master Data / Pengaturan (Dropdown) -->
            @php
                $isMasterActive = request()->routeIs('user*', 'tahunakademik*', 'kategorysk*');
            @endphp
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between {{ $isMasterActive ? 'bg-light text-dark' : '' }}" 
                   data-bs-toggle="collapse" 
                   href="#collapseMasterData" 
                   role="button" 
                   aria-expanded="{{ $isMasterActive ? 'true' : 'false' }}" 
                   aria-controls="collapseMasterData">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm shadow-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center bg-white" style="color: #046B26;">
                            <i class="fas fa-cogs" style="font-size: 13px;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Master & Pengaturan</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow text-secondary ms-auto"></i>
                </a>
                <div class="collapse {{ $isMasterActive ? 'show' : '' }}" id="collapseMasterData">
                    <ul class="sidebar-submenu">
                        @if (auth()->check() && auth()->user()->roles !== 'dosen')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('user*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                                    <span class="sub-bullet"></span> Data Pengguna
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tahunakademik*') ? 'active' : '' }}" href="{{ route('tahunakademik.index') }}">
                                <span class="sub-bullet"></span> Tahun Akademik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kategorysk*') ? 'active' : '' }}" href="{{ route('kategorysk.index') }}">
                                <span class="sub-bullet"></span> Kategori SK
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

        <!-- Sidenav Footer Profile & Logout -->
        <div class="sidenav-footer mx-3 mt-4 mb-3">
            <div class="card card-background shadow-none card-background-mask-secondary border-radius-lg" id="sidenavCard">
                <div class="full-background" style="background-image: url('{{ asset('dashboard/assets/img/curved-images/white-curved.jpeg') }}')"></div>
                <div class="card-body text-start p-3 w-100">
                    <div class="icon icon-shape icon-sm bg-white shadow text-center mb-2 d-flex align-items-center justify-content-center border-radius-md" style="color: #046B26;">
                        <i class="fas fa-user-circle fs-6"></i>
                    </div>
                    <div class="docs-info">
                        <h6 class="text-white up mb-0 text-sm font-weight-bolder">{{ Auth::user()->name }}</h6>
                        <span class="badge bg-gradient-success text-white mb-2" style="font-size: 10px; padding: 2px 8px; text-transform: uppercase;">
                            {{ Auth::user()->roles }}
                        </span>
                        <p class="text-xxs text-white-50 mb-2 text-truncate">{{ Auth::user()->email }}</p>
                        <a href="{{ route('logout') }}" class="btn btn-sm w-100 text-white font-weight-bold"
                            style="background: #046B26; box-shadow: 0 4px 10px rgba(0,0,0,0.2); border-radius: 6px;">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
