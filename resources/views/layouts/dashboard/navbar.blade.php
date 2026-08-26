<style>
    /* Prevent unwanted scrollbars on navbar */
    #navbarBlur, #navbarBlur * {
        scrollbar-width: none; /* Firefox */
    }
    #navbarBlur::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Edge */
    }
    #navbarBlur .ps__rail-x, #navbarBlur .ps__rail-y {
        display: none !important;
    }
    .user-dropdown-btn:hover {
        background: rgba(0, 0, 0, 0.04);
        border-radius: 10px;
    }
    .dropdown-item-hover:hover {
        background-color: #f1f5f9 !important;
        color: #046B26 !important;
    }
    /* Mobile dropdown alignment */
    @media (max-width: 576px) {
        .navbar-main {
            margin-left: 0.75rem !important;
            margin-right: 0.75rem !important;
            padding: 0.25rem 0.5rem !important;
        }
        .user-dropdown-menu {
            right: 0 !important;
            left: auto !important;
            min-width: 240px !important;
            max-width: calc(100vw - 2rem) !important;
        }
    }
</style>

<nav class="navbar navbar-main px-0 mx-2 mx-md-4 mt-2 mt-md-3 shadow-sm border-radius-xl bg-white position-sticky top-1 z-index-sticky" id="navbarBlur" navbar-scroll="true" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95) !important; border: 1px solid rgba(0,0,0,0.06); overflow: visible !important;">
    <div class="container-fluid py-1 px-2 px-sm-3 d-flex justify-content-between align-items-center flex-nowrap" style="min-height: 48px;">
        <!-- Left: Breadcrumb & Mobile Hamburger -->
        <div class="d-flex align-items-center me-2 overflow-hidden" style="min-width: 0;">
            <!-- Mobile Hamburger Toggle -->
            <button class="btn btn-link text-dark p-0 me-2 me-sm-3 d-xl-none fs-5 mb-0 shadow-none flex-shrink-0" id="btnToggleMobileSidebar" type="button" aria-label="Toggle Sidebar" style="line-height: 1; cursor: pointer;">
                <i class="fas fa-bars text-dark" style="pointer-events: none; font-size: 1.25rem;"></i>
            </button>
            <div class="overflow-hidden">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-0 px-0 d-none d-sm-flex">
                    <li class="breadcrumb-item text-xxs"><a class="opacity-5 text-dark" href="{{ route('dashboard') }}"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="breadcrumb-item text-xxs text-dark active font-weight-bold" aria-current="page">@yield('title', 'E-Arsip')</li>
                </ol>
                <h6 class="font-weight-bolder mb-0 text-dark text-truncate" style="font-size: 0.9rem; max-width: 100%;">@yield('title', 'Dashboard')</h6>
            </div>
        </div>

        <!-- Right: User Menu Dropdown -->
        <div class="d-flex align-items-center flex-shrink-0 position-relative">
            @if(Auth::check())
                @php
                    $roleLabels = [
                        'admin'       => ['label' => 'Admin', 'bg' => 'bg-danger'],
                        'tatausaha'   => ['label' => 'Tata Usaha', 'bg' => 'bg-primary'],
                        'dosen'       => ['label' => 'Dosen', 'bg' => 'bg-info'],
                        'dekan'       => ['label' => 'Dekan', 'bg' => 'bg-success'],
                        'wakilDekan1' => ['label' => 'Wakil Dekan 1', 'bg' => 'bg-warning text-dark'],
                        'wakilDekan2' => ['label' => 'Wakil Dekan 2', 'bg' => 'bg-warning text-dark'],
                        'kaprodi'     => ['label' => 'Kaprodi', 'bg' => 'bg-dark'],
                        'sekprodi'    => ['label' => 'Sekprodi', 'bg' => 'bg-secondary'],
                    ];
                    $userRole = Auth::user()->roles ?? 'dosen';
                    $roleData = $roleLabels[$userRole] ?? ['label' => ucfirst($userRole), 'bg' => 'bg-secondary'];
                @endphp
                <div class="dropdown position-relative">
                    <a href="javascript:;" class="d-flex align-items-center px-1 px-sm-2 py-1 user-dropdown-btn text-decoration-none" id="userDropdown" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <div class="avatar avatar-sm rounded-circle text-white font-weight-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 13px; background: #046B26; box-shadow: 0 2px 8px rgba(4, 107, 38, 0.3);">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="d-none d-md-block text-start ms-2 me-1">
                            <span class="d-block text-xs font-weight-bold text-dark mb-0">{{ Auth::user()->name }}</span>
                            <span class="badge {{ $roleData['bg'] }} text-xxs px-2 py-0" style="font-size: 10px; border-radius: 4px;">{{ $roleData['label'] }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-xxs text-secondary ms-1"></i>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu px-2 py-2 mt-2 shadow-lg" aria-labelledby="userDropdown" style="position: absolute; right: 0; left: auto; min-width: 230px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 10px 30px rgba(0,0,0,0.12);">
                        <!-- Header info -->
                        <li class="px-2 py-2 mb-1 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm rounded-circle me-2 text-white font-weight-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 30px; height: 30px; font-size: 12px; background: #046B26;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="overflow-hidden" style="min-width: 0;">
                                    <h6 class="text-xs font-weight-bold text-dark mb-0 text-truncate">{{ Auth::user()->name }}</h6>
                                    <p class="text-xxs text-secondary mb-0 text-truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </li>

                        <!-- Menu 1: Profile -->
                        <li>
                            <a class="dropdown-item dropdown-item-hover border-radius-md d-flex align-items-center py-2 text-dark font-weight-bold text-xs" href="javascript:;" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <i class="fas fa-user-circle me-2 text-info" style="font-size: 14px;"></i>
                                <span>Profil Pengguna</span>
                            </a>
                        </li>

                        <!-- Menu 2: Update Password -->
                        <li>
                            <a class="dropdown-item dropdown-item-hover border-radius-md d-flex align-items-center py-2 text-dark font-weight-bold text-xs" href="{{ route('user.showUpdatePasswordForm', Auth::id()) }}">
                                <i class="fas fa-key me-2 text-warning" style="font-size: 14px;"></i>
                                <span>Update Password</span>
                            </a>
                        </li>

                        <li><hr class="dropdown-divider my-1"></li>

                        <!-- Menu 3: Logout -->
                        <li>
                            <a class="dropdown-item dropdown-item-hover border-radius-md d-flex align-items-center py-2 text-danger font-weight-bold text-xs" href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt me-2 text-danger" style="font-size: 14px;"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</nav>

<!-- Modal Profil Pengguna -->
@if(Auth::check())
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white" style="background: linear-gradient(310deg, #046B26 0%, #0db846 100%); border-bottom: none;">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-md bg-white text-dark font-weight-bold rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px; color: #046B26 !important;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="modal-title text-white font-weight-bold mb-0 text-truncate" style="max-width: 170px;" id="profileModalLabel">{{ Auth::user()->name }}</h6>
                        <span class="badge bg-white text-dark text-xxs mt-1" style="font-weight: 700;">{{ $roleData['label'] }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-sm-4">
                <div class="row g-2">
                    <div class="col-12 pb-2 border-bottom">
                        <label class="text-xxs text-secondary text-uppercase font-weight-bold mb-1">Email</label>
                        <p class="text-xs font-weight-bold text-dark mb-0 text-break"><i class="fas fa-envelope text-secondary me-2"></i>{{ Auth::user()->email }}</p>
                    </div>
                    <div class="col-12 pb-2 border-bottom">
                        <label class="text-xxs text-secondary text-uppercase font-weight-bold mb-1">Role / Hak Akses</label>
                        <p class="text-xs font-weight-bold text-dark mb-0"><i class="fas fa-shield-alt text-secondary me-2"></i>{{ $roleData['label'] }}</p>
                    </div>
                    <div class="col-12 pb-2 border-bottom">
                        <label class="text-xxs text-secondary text-uppercase font-weight-bold mb-1">Fakultas</label>
                        <p class="text-xs font-weight-bold text-dark mb-0"><i class="fas fa-university text-secondary me-2"></i>{{ Auth::user()->fakultas ?? 'Universitas Ibnu Sina' }}</p>
                    </div>
                    <div class="col-12">
                        <label class="text-xxs text-secondary text-uppercase font-weight-bold mb-1">Homebase / Program Studi</label>
                        <p class="text-xs font-weight-bold text-dark mb-0"><i class="fas fa-graduation-cap text-secondary me-2"></i>{{ Auth::user()->homebase ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light p-2 border-0 d-flex justify-content-between">
                <a href="{{ route('user.showUpdatePasswordForm', Auth::id()) }}" class="btn btn-xs btn-dark mb-0">
                    <i class="fas fa-key me-1"></i> Ubah Password
                </a>
                <button type="button" class="btn btn-xs btn-secondary mb-0" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif