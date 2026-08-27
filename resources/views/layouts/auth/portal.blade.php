<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('dashboard/assets/img/uis.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('dashboard/assets/img/uis.png') }}">
    <title>Pilih Portal Hak Akses | Universitas Ibnu Sina</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('dashboard/assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />

    <style>
        :root {
            --brand-primary: #046B26;
            --brand-primary-dark: #034827;
        }

        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            box-sizing: border-box;
        }

        html, body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* Campus Photo Background */
        .bg-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: url('{{ asset('dashboard/assets/img/gedung.JPG') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            z-index: 1;
        }

        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.72) 0%, rgba(30, 41, 59, 0.82) 100%);
            backdrop-filter: blur(4px);
            z-index: 2;
        }

        .portal-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 920px;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .portal-card-box {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .role-portal-item {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            padding: 1.5rem;
            position: relative;
        }

        .role-portal-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.12);
            border-color: #046B26 !important;
        }

        .role-icon-box {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
            transition: transform 0.25s ease;
        }

        .role-portal-item:hover .role-icon-box {
            transform: scale(1.08);
        }
    </style>
</head>

<body>
    <!-- Background Elements -->
    <div class="bg-backdrop"></div>
    <div class="bg-overlay"></div>

    @php
        $authUser = Auth::user();
        $userRoles = $authUser ? $authUser->roles : [];
        $activeRole = $authUser ? $authUser->getActiveRole() : '';

        $roleDefinitions = [
            'admin' => [
                'name' => 'Administrator',
                'title' => 'Portal Admin',
                'subtitle' => 'Kelola Pengguna & Seluruh Arsip Sistem',
                'icon' => 'fas fa-shield-halved',
                'icon_color' => '#dc2626',
                'bg_icon' => '#fee2e2',
                'accent' => '#dc2626',
            ],
            'dekan' => [
                'name' => 'Dekan',
                'title' => 'Portal Dekan',
                'subtitle' => 'Monitoring Eksekutif Fakultas ' . ($authUser->fakultas ?? ''),
                'icon' => 'fas fa-crown',
                'icon_color' => '#059669',
                'bg_icon' => '#d1fae5',
                'accent' => '#059669',
            ],
            'wakilDekan1' => [
                'name' => 'Wakil Dekan 1',
                'title' => 'Portal Wakil Dekan 1',
                'subtitle' => 'Bidang Akademik & Kurikulum Fakultas',
                'icon' => 'fas fa-book-open-reader',
                'icon_color' => '#2563eb',
                'bg_icon' => '#dbeafe',
                'accent' => '#2563eb',
            ],
            'wakilDekan2' => [
                'name' => 'Wakil Dekan 2',
                'title' => 'Portal Wakil Dekan 2',
                'subtitle' => 'Bidang Umum, Keuangan & SDM Fakultas',
                'icon' => 'fas fa-briefcase',
                'icon_color' => '#d97706',
                'bg_icon' => '#fef3c7',
                'accent' => '#d97706',
            ],
            'kaprodi' => [
                'name' => 'Kaprodi',
                'title' => 'Portal Kaprodi',
                'subtitle' => 'Monitoring Dosen & SK ' . ($authUser->homebase ?? 'Prodi'),
                'icon' => 'fas fa-graduation-cap',
                'icon_color' => '#0d9488',
                'bg_icon' => '#ccfbf1',
                'accent' => '#0d9488',
            ],
            'sekprodi' => [
                'name' => 'Sekprodi',
                'title' => 'Portal Sekprodi',
                'subtitle' => 'Operasional & Administrasi ' . ($authUser->homebase ?? 'Prodi'),
                'icon' => 'fas fa-file-pen',
                'icon_color' => '#475569',
                'bg_icon' => '#f1f5f9',
                'accent' => '#475569',
            ],
            'tatausaha' => [
                'name' => 'Tata Usaha',
                'title' => 'Portal Tata Usaha',
                'subtitle' => 'Penerbitan & Tata Kelola SK Fakultas',
                'icon' => 'fas fa-folder-open',
                'icon_color' => '#046B26',
                'bg_icon' => '#E8F5E9',
                'accent' => '#046B26',
            ],
            'dosen' => [
                'name' => 'Dosen',
                'title' => 'Portal Dosen',
                'subtitle' => 'Arsip SK & Kinerja Pribadi Dosen',
                'icon' => 'fas fa-chalkboard-teacher',
                'icon_color' => '#0284c7',
                'bg_icon' => '#e0f2fe',
                'accent' => '#0284c7',
            ],
        ];
    @endphp

    <div class="portal-wrapper">
        <div class="portal-card-box">
            <!-- Header Banner Sesuai Gambar Referensi UIS -->
            <div class="p-3 p-md-4 text-white" style="background: linear-gradient(135deg, #0b4f8a 0%, #002d62 100%);">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white p-1.5 rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; min-width: 56px;">
                            <img src="{{ asset('dashboard/assets/img/uis.png') }}" alt="Logo UIS" class="img-fluid" style="max-height: 44px;">
                        </div>
                        <div>
                            <span class="text-xs text-white-50 text-uppercase font-weight-bold d-block" style="letter-spacing: 0.5px;">Sistem Informasi E-Arsip Digital</span>
                            <h5 class="text-white font-weight-bolder mb-0 text-uppercase" style="letter-spacing: 0.8px;">UNIVERSITAS IBNU SINA</h5>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="text-end d-none d-md-block me-2">
                            <span class="text-xs text-white-50 d-block">Masuk sebagai:</span>
                            <span class="text-xs font-weight-bold text-white">{{ $authUser->name }}</span>
                        </div>
                        <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-white text-white px-3 py-2 rounded-3 mb-0 text-xs font-weight-bold d-inline-flex align-items-center gap-1.5" style="border: 1.5px solid rgba(255,255,255,0.6) !important;">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Body Content -->
            <div class="p-4 p-md-5" style="background-color: #f8fafc;">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                    <div>
                        <h4 class="font-weight-bolder text-dark mb-1">Daftar Modul & Hak Akses Anda</h4>
                        <p class="text-xs text-muted mb-0">Silakan klik salah satu peran di bawah untuk mengaktifkan ruang kerja dan masuk ke Dashboard:</p>
                    </div>
                    <span class="badge bg-white text-dark border px-3 py-2 rounded-pill text-xs font-weight-bold shadow-none align-self-start align-self-sm-center">
                        {{ count($userRoles) }} PERAN TERSEDIA
                    </span>
                </div>

                <!-- Grid of Roles -->
                <div class="row g-3 g-md-4">
                    @foreach($userRoles as $roleKey)
                        @php
                            $roleInfo = $roleDefinitions[$roleKey] ?? [
                                'name' => ucfirst($roleKey),
                                'title' => 'Portal ' . ucfirst($roleKey),
                                'subtitle' => 'Akses ' . ucfirst($roleKey),
                                'icon' => 'fas fa-user-check',
                                'icon_color' => '#046B26',
                                'bg_icon' => '#E8F5E9',
                                'accent' => '#046B26',
                            ];
                        @endphp

                        <div class="col-12 col-sm-6 col-lg-{{ count($userRoles) == 2 ? '6' : '4' }}">
                            <a href="{{ route('switch.role.get', ['role' => $roleKey]) }}" class="role-portal-item">
                                <div class="text-center pt-2">
                                    <div class="role-icon-box" style="background-color: {{ $roleInfo['bg_icon'] }};">
                                        <i class="{{ $roleInfo['icon'] }} fs-2" style="color: {{ $roleInfo['icon_color'] }};"></i>
                                    </div>
                                    <h5 class="font-weight-bolder text-dark mb-1 fs-6">{{ $roleInfo['title'] }}</h5>
                                    <p class="text-xs text-muted mb-0">{{ $roleInfo['subtitle'] }}</p>
                                </div>

                                <div class="mt-4 pt-3 border-top w-100 text-center">
                                    <span class="btn btn-sm btn-primary w-100 mb-0 font-weight-bold rounded-3 shadow-sm" style="font-size: 0.82rem;">
                                        Masuk Portal <i class="fas fa-arrow-right ms-1 text-xs"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center mt-3 text-white-50 text-xs">
            © {{ date('Y') }} Sistem E-Arsip Digital Universitas Ibnu Sina. All rights reserved.
        </div>
    </div>
</body>

</html>
