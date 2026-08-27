<style>
    #sidenav-collapse-main {
        display: block;
    }
    .sidenav .nav-link {
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
        font-weight: 600;
        font-size: 0.8125rem;
        padding: 0.65rem 0.85rem !important;
    }
    /* Matikan panah default template Soft UI agar tidak dobel */
    .sidenav .nav-link[data-bs-toggle="collapse"]::after,
    .navbar-vertical .navbar-nav .nav-link[data-bs-toggle="collapse"]::after {
        display: none !important;
        content: none !important;
    }
    .sidenav .nav-link:hover {
        background-color: rgba(4, 107, 38, 0.08);
    }
    .sidenav .nav-link.active {
        background: #046B26 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(4, 107, 38, 0.25);
    }
    .sidenav .nav-link.active .nav-link-text {
        color: #ffffff !important;
        font-weight: 700;
    }

    /* Icon Box khusus untuk menu utama */
    .menu-icon-box {
        width: 32px;
        height: 32px;
        min-width: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        margin-right: 10px;
        transition: all 0.2s ease;
    }
    .menu-icon-box i {
        color: #046B26 !important;
        font-size: 13px !important;
        line-height: 1 !important;
        display: inline-block !important;
    }
    .sidenav .nav-link.active .menu-icon-box {
        background: rgba(255, 255, 255, 0.2) !important;
        box-shadow: none !important;
    }
    .sidenav .nav-link.active .menu-icon-box i {
        color: #ffffff !important;
    }

    /* Chevron Dropdown Arrow */
    .sidebar-dropdown-arrow {
        transition: transform 0.25s ease, color 0.25s ease;
        font-size: 0.75rem;
        color: #8392ab;
        display: inline-block;
    }
    .nav-link[aria-expanded="true"] .sidebar-dropdown-arrow {
        transform: rotate(180deg);
        color: #046B26;
    }

    /* Submenu styling */
    .sidebar-submenu {
        padding-left: 1.25rem;
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
    .sidebar-submenu .nav-link i {
        width: 20px;
        text-align: center;
        margin-right: 8px;
        color: #94a3b8 !important;
        font-size: 13px !important;
        transition: all 0.2s ease;
    }
    .sidebar-submenu .nav-link:hover {
        color: #046B26 !important;
        background: rgba(4, 107, 38, 0.06);
    }
    .sidebar-submenu .nav-link:hover i {
        color: #046B26 !important;
    }
    .sidebar-submenu .nav-link.active {
        background: rgba(4, 107, 38, 0.12) !important;
        color: #046B26 !important;
        font-weight: 700 !important;
        box-shadow: none !important;
    }
    .sidebar-submenu .nav-link.active i {
        color: #046B26 !important;
        transform: scale(1.15);
    }
</style>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
    <div class="sidenav-header position-relative">
        <i class="fas fa-xmark p-3 cursor-pointer text-secondary position-absolute end-0 top-0 d-xl-none fs-6"
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
                    <div class="menu-icon-box">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>

            <!-- 2. Identitas Karya Ilmiah -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('identitaskaryailmiah*') ? 'active' : '' }}" href="{{ route('identitaskaryailmiah.index') }}">
                    <div class="menu-icon-box">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span class="nav-link-text">Identitas Karya Ilmiah</span>
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
                        <div class="menu-icon-box">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <span class="nav-link-text">Bidang Pendidikan</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow ms-auto"></i>
                </a>
                <div class="collapse {{ $isPendidikanActive ? 'show' : '' }}" id="collapsePendidikan">
                    <ul class="sidebar-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpengajaran*') ? 'active' : '' }}" href="{{ route('skpengajaran.index') }}">
                                <i class="fas fa-chalkboard-user"></i> SK Pengajaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpembimbingakademik*') ? 'active' : '' }}" href="{{ route('skpembimbingakademik.index') }}">
                                <i class="fas fa-user-graduate"></i> SK Pembimbing Akademik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpembimbingkpm*') ? 'active' : '' }}" href="{{ route('skpembimbingkpm.index') }}">
                                <i class="fas fa-hand-holding-heart"></i> SK Pembimbing KPM
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpembimbingtugasakhir*') ? 'active' : '' }}" href="{{ route('skpembimbingtugasakhir.index') }}">
                                <i class="fas fa-file-pen"></i> SK Pembimbing TA
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpengujisempro*') ? 'active' : '' }}" href="{{ route('skpengujisempro.index') }}">
                                <i class="fas fa-list-check"></i> SK Penguji Sempro
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpengujitugasakhir*') ? 'active' : '' }}" href="{{ route('skpengujitugasakhir.index') }}">
                                <i class="fas fa-user-check"></i> SK Penguji Tugas Akhir
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- 4. Bidang Penelitian (Dropdown) -->
            @php
                $isPenelitianActive = request()->routeIs('buku*');
            @endphp
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between {{ $isPenelitianActive ? 'bg-light text-dark' : '' }}" 
                   data-bs-toggle="collapse" 
                   href="#collapsePenelitian" 
                   role="button" 
                   aria-expanded="{{ $isPenelitianActive ? 'true' : 'false' }}" 
                   aria-controls="collapsePenelitian">
                    <div class="d-flex align-items-center">
                        <div class="menu-icon-box">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <span class="nav-link-text">Bidang Penelitian</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow ms-auto"></i>
                </a>
                <div class="collapse {{ $isPenelitianActive ? 'show' : '' }}" id="collapsePenelitian">
                    <ul class="sidebar-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('buku*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                                <i class="fas fa-book"></i> Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-shield-halved"></i> HAKI
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-newspaper"></i> Pengelola Jurnal
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
                        <div class="menu-icon-box">
                            <i class="fas fa-handshake-angle"></i>
                        </div>
                        <span class="nav-link-text">Bidang Pengabdian</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow ms-auto"></i>
                </a>
                <div class="collapse" id="collapsePengabdian">
                    <ul class="sidebar-submenu">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-file-contract"></i> Laporan Pengabdian
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
                        <div class="menu-icon-box">
                            <i class="fas fa-award"></i>
                        </div>
                        <span class="nav-link-text">Penunjang</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-dropdown-arrow ms-auto"></i>
                </a>
                <div class="collapse {{ $isPenunjangActive ? 'show' : '' }}" id="collapsePenunjang">
                    <ul class="sidebar-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skkepanitiaan*') ? 'active' : '' }}" href="{{ route('skkepanitiaan.index') }}">
                                <i class="fas fa-clipboard-list"></i> SK Panitia / Kepanitiaan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-id-card-clip"></i> SK Anggota Profesi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpengangkatanstruktural*') ? 'active' : '' }}" href="{{ route('skpengangkatanstruktural.index') }}">
                                <i class="fas fa-sitemap"></i> SK Jabatan Struktural
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @if (auth()->check() && auth()->user()->roles !== 'dosen')
                <!-- 7. LPJ Kegiatan Panitia Tahunan (Dropdown) -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center justify-content-between" 
                       data-bs-toggle="collapse" 
                       href="#collapseLPJ" 
                       role="button" 
                       aria-expanded="false" 
                       aria-controls="collapseLPJ">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon-box">
                                <i class="fas fa-folder-closed"></i>
                            </div>
                            <span class="nav-link-text">LPJ Kegiatan Panitia</span>
                        </div>
                        <i class="fas fa-chevron-down sidebar-dropdown-arrow ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseLPJ">
                        <ul class="sidebar-submenu">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-magnifying-glass-chart"></i> Audit Mutu Internal
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-heart-pulse"></i> Pendidikan Karakter
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-user-plus"></i> PMB
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-cake-candles"></i> Milad
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-user-graduate"></i> Wisuda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-building-columns"></i> LPPM
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
                            <div class="menu-icon-box">
                                <i class="fas fa-sliders"></i>
                            </div>
                            <span class="nav-link-text">Master & Pengaturan</span>
                        </div>
                        <i class="fas fa-chevron-down sidebar-dropdown-arrow ms-auto"></i>
                    </a>
                    <div class="collapse {{ $isMasterActive ? 'show' : '' }}" id="collapseMasterData">
                        <ul class="sidebar-submenu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('user*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                                    <i class="fas fa-users-gear"></i> Data Pengguna
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tahunakademik*') ? 'active' : '' }}" href="{{ route('tahunakademik.index') }}">
                                    <i class="fas fa-calendar-days"></i> Tahun Akademik
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('kategorysk*') ? 'active' : '' }}" href="{{ route('kategorysk.index') }}">
                                    <i class="fas fa-tags"></i> Kategori SK
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>

        <!-- Sidenav Footer Profile & Logout -->
        <div class="sidenav-footer mx-3 mt-4 mb-3">
            <div class="card card-background shadow-none card-background-mask-secondary border-radius-lg" id="sidenavCard">
                <div class="full-background" style="background-image: url('{{ asset('dashboard/assets/img/curved-images/white-curved.jpeg') }}')"></div>
                <div class="card-body text-start p-3 w-100">
                    <div class="menu-icon-box mb-2" style="background: #ffffff;">
                        <i class="fas fa-user-shield" style="font-size: 15px !important; color: #046B26 !important;"></i>
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
