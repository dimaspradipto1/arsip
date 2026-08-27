<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('dashboard/assets/img/uis.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('dashboard/assets/img/uis.png') }}">
    <title>E-Arsip | Universitas Ibnu Sina</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('dashboard/assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />

    <style>
        :root {
            --brand-primary: #056839;
            --brand-primary-dark: #034827;
            --brand-primary-light: #0d8a4f;
            --brand-accent: #f59e0b;
            --surface-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #0f172a;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* Direct Image Background without green tint */
        .bg-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: linear-gradient(rgba(15, 23, 42, 0.35), rgba(15, 23, 42, 0.45)),
                              url('{{ asset('dashboard/assets/img/gedung.JPG') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
        }

        /* Main Container Card */
        .auth-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1040px;
            margin: auto;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
        }

        /* Left Hero Showcase Side */
        .showcase-pane {
            position: relative;
            background: linear-gradient(145deg, #055831 0%, #02361d 100%);
            padding: 44px 38px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            color: #ffffff;
        }

        .showcase-pane::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ asset('dashboard/assets/img/gedung.JPG') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.16;
            mix-blend-mode: overlay;
        }

        .showcase-content {
            position: relative;
            z-index: 2;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            padding: 8px 16px;
            border-radius: 100px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 22px;
        }

        .brand-logo-img {
            width: 36px;
            height: 36px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .brand-badge-text {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #ffffff;
            text-transform: uppercase;
        }

        .showcase-title {
            font-size: 2.1rem;
            font-weight: 800;
            line-height: 1.2;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .showcase-subtitle {
            font-size: 1rem;
            font-weight: 500;
            color: #a7f3d0;
            margin-bottom: 4px;
        }

        .showcase-motto {
            font-size: 0.84rem;
            font-style: italic;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 26px;
        }

        /* Feature List */
        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.14);
            padding: 11px 16px;
            border-radius: 14px;
            transition: all 0.25s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.16);
            transform: translateX(4px);
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .feature-text h6 {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
        }

        .feature-text p {
            margin: 0;
            font-size: 0.74rem;
            color: rgba(255, 255, 255, 0.75);
        }

        .showcase-footer {
            position: relative;
            z-index: 2;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            font-size: 0.76rem;
            color: rgba(255, 255, 255, 0.65);
        }

        /* Right Login Form Side */
        .form-pane {
            padding: 44px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .form-header {
            margin-bottom: 24px;
        }

        .portal-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            color: #047857;
            font-size: 0.74rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            margin-bottom: 10px;
            border: 1px solid #d1fae5;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .form-desc {
            font-size: 0.86rem;
            color: var(--text-muted);
            margin: 0;
        }

        /* Form Inputs */
        .form-group-custom {
            margin-bottom: 18px;
        }

        .form-label-custom {
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 15px;
            color: #94a3b8;
            font-size: 0.95rem;
            transition: color 0.2s ease;
            pointer-events: none;
            z-index: 4;
        }

        .custom-input {
            width: 100%;
            height: 46px;
            padding: 10px 14px 10px 42px;
            font-size: 0.88rem;
            color: #0f172a;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
        }

        .custom-input:focus {
            background: #ffffff;
            border-color: #056839;
            box-shadow: 0 0 0 4px rgba(5, 104, 57, 0.12);
            outline: none;
        }

        .custom-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .custom-input.is-invalid {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        .custom-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12);
        }

        .input-wrapper:focus-within .input-icon-left {
            color: #056839;
        }

        .password-toggle-btn {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 0.95rem;
            padding: 8px;
            cursor: pointer;
            transition: color 0.2s ease;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
        }

        .password-toggle-btn:hover {
            color: #334155;
            background: rgba(0, 0, 0, 0.04);
        }

        .invalid-feedback-custom {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #ef4444;
            font-size: 0.76rem;
            font-weight: 600;
            margin-top: 5px;
        }

        /* Login Button */
        .btn-submit-login {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #056839 0%, #034827 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 0.92rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px -5px rgba(5, 104, 57, 0.4);
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-submit-login:hover {
            background: linear-gradient(135deg, #067c44 0%, #045a31 100%);
            box-shadow: 0 14px 28px -6px rgba(5, 104, 57, 0.5);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .btn-submit-login:active {
            transform: translateY(0);
            box-shadow: 0 6px 12px -3px rgba(5, 104, 57, 0.4);
        }

        .btn-submit-login i {
            transition: transform 0.2s ease;
        }

        .btn-submit-login:hover i {
            transform: translateX(4px);
        }

        /* Security Assurance Banner */
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.74rem;
            color: #64748b;
            text-align: center;
        }

        .security-note i {
            color: #10b981;
        }

        /* Mobile Logo Header */
        .mobile-header {
            display: none;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991.98px) {
            .auth-card {
                border-radius: 20px;
            }
            .showcase-pane {
                padding: 32px 28px;
            }
            .form-pane {
                padding: 32px 28px;
            }
            .showcase-title {
                font-size: 1.8rem;
            }
        }

        /* Mobile Fit Screen (No Scroll) */
        @media (max-width: 767.98px) {
            body {
                padding: 12px 14px;
                min-height: 100vh;
                min-height: 100dvh;
                height: 100dvh;
                overflow: hidden;
            }
            .auth-wrapper {
                max-width: 400px;
                margin: auto;
            }
            .auth-card {
                border-radius: 18px;
                box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.5);
            }
            .showcase-pane {
                display: none;
            }
            .form-pane {
                padding: 22px 20px 18px 20px;
            }
            
            /* Compact Mobile Header */
            .mobile-header {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 16px;
                padding-bottom: 12px;
                border-bottom: 1px solid #f1f5f9;
                text-align: left;
            }
            .mobile-header img {
                width: 42px;
                height: 42px;
                object-fit: contain;
                flex-shrink: 0;
            }
            .mobile-header-text h5 {
                font-size: 1.1rem;
                font-weight: 800;
                color: #0f172a;
                margin: 0;
                line-height: 1.2;
            }
            .mobile-header-text small {
                font-size: 0.76rem;
                color: #64748b;
                display: block;
                font-weight: 500;
            }

            /* Compact Form Header on Mobile */
            .form-header {
                margin-bottom: 16px;
            }
            .portal-tag {
                display: inline-flex;
                font-size: 0.68rem;
                padding: 2px 8px;
                margin-bottom: 6px;
            }
            .form-title {
                font-size: 1.25rem;
                margin-bottom: 2px;
            }
            .form-desc {
                font-size: 0.78rem;
            }

            /* Compact Inputs */
            .form-group-custom {
                margin-bottom: 12px;
            }
            .form-label-custom {
                font-size: 0.76rem;
                margin-bottom: 4px;
            }
            .custom-input {
                height: 42px;
                font-size: 0.84rem;
                padding: 8px 12px 8px 38px;
                border-radius: 10px;
            }
            .input-icon-left {
                left: 13px;
                font-size: 0.85rem;
            }
            .password-toggle-btn {
                right: 6px;
                font-size: 0.85rem;
                padding: 6px;
            }

            /* Compact Button & Footer */
            .btn-submit-login {
                height: 42px;
                font-size: 0.86rem;
                margin-top: 14px !important;
                border-radius: 10px;
            }
            .security-note {
                margin-top: 12px;
                padding-top: 10px;
                font-size: 0.68rem;
                gap: 5px;
            }
        }

        /* Extra small height screens */
        @media (max-height: 650px) and (max-width: 767.98px) {
            .form-pane {
                padding: 16px 16px 14px 16px;
            }
            .mobile-header {
                margin-bottom: 10px;
                padding-bottom: 8px;
            }
            .mobile-header img {
                width: 34px;
                height: 34px;
            }
            .form-header {
                display: none;
            }
            .form-group-custom {
                margin-bottom: 8px;
            }
            .custom-input {
                height: 38px;
            }
            .btn-submit-login {
                height: 38px;
                margin-top: 10px !important;
            }
            .security-note {
                margin-top: 8px;
                padding-top: 6px;
            }
        }
    </style>
</head>

<body>
    <!-- Direct Campus Background Image -->
    <div class="bg-backdrop"></div>

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="row g-0">
                <!-- Left Column: Branding & Feature Showcase (Desktop Only) -->
                <div class="col-lg-6 d-none d-lg-flex showcase-pane">
                    <div class="showcase-content">
                        <div class="brand-badge">
                            <img src="{{ asset('dashboard/assets/img/uis.png') }}" alt="Logo UIS" class="brand-logo-img">
                            <span class="brand-badge-text">Universitas Ibnu Sina</span>
                        </div>

                        <h1 class="showcase-title">E-ARSIP</h1>
                        <h4 class="showcase-subtitle">Sistem Informasi Manajemen Arsip</h4>
                        <p class="showcase-motto">"Kampusnya Profesional Muda"</p>

                        <div class="feature-list">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-folder-tree"></i>
                                </div>
                                <div class="feature-text">
                                    <h6>Manajemen Dokumen Digital</h6>
                                    <p>Pengarsipan berkas surat & dokumen secara terstruktur</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                                <div class="feature-text">
                                    <h6>Pencarian Cepat & Akurat</h6>
                                    <p>Temu kembali arsip dengan filter kategori dan penomoran</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div class="feature-text">
                                    <h6>Keamanan Data Terstandar</h6>
                                    <p>Hak akses terproteksi dan terenkripsi secara menyeluruh</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="showcase-footer">
                        <span>&copy; {{ date('Y') }} E-Arsip UIS &bull; Batam, Kepulauan Riau</span>
                    </div>
                </div>

                <!-- Right Column: Login Form -->
                <div class="col-lg-6 col-12 form-pane">
                    <!-- Compact Mobile Header -->
                    <div class="mobile-header">
                        <img src="{{ asset('dashboard/assets/img/uis.png') }}" alt="Logo UIS">
                        <div class="mobile-header-text">
                            <h5>E-ARSIP UIS</h5>
                            <small>Universitas Ibnu Sina</small>
                        </div>
                    </div>

                    <div class="form-header">
                        <span class="portal-tag">
                            <i class="fa-solid fa-circle-check"></i> Portal Akses Resmi
                        </span>
                        <h2 class="form-title">Masuk ke Akun</h2>
                        <p class="form-desc">Silakan masukkan email dan kata sandi Anda untuk melanjutkan.</p>
                    </div>

                    <form action="{{ route('loginproses') }}" method="POST" autocomplete="on">
                        @csrf

                        <!-- Email Input -->
                        <div class="form-group-custom">
                            <label for="emailInput" class="form-label-custom">Alamat Email</label>
                            <div class="input-wrapper">
                                <i class="fa-regular fa-envelope input-icon-left"></i>
                                <input type="email" 
                                       name="email" 
                                       id="emailInput" 
                                       class="custom-input @error('email') is-invalid @enderror" 
                                       placeholder="nama@uis.ac.id" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback-custom">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-group-custom">
                            <label for="passwordInput" class="form-label-custom">Kata Sandi</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-lock input-icon-left"></i>
                                <input type="password" 
                                       name="password" 
                                       id="passwordInput" 
                                       class="custom-input @error('password') is-invalid @enderror" 
                                       placeholder="Masukkan kata sandi" 
                                       required>
                                <button type="button" 
                                        class="password-toggle-btn" 
                                        id="togglePasswordBtn" 
                                        aria-label="Tampilkan atau sembunyikan kata sandi"
                                        tabindex="-1">
                                    <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback-custom">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit-login mt-4">
                            <span>Masuk ke Sistem</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>

                    <div class="security-note">
                        <i class="fa-solid fa-lock"></i>
                        <span>Koneksi aman terenkripsi SSL UIS.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('dashboard/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/core/bootstrap.min.js') }}"></script>
    @include('sweetalert::alert')

    <script>
        // Password Visibility Toggle
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('passwordInput');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        if (togglePasswordBtn && passwordInput && togglePasswordIcon) {
            togglePasswordBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    togglePasswordIcon.classList.remove('fa-eye');
                    togglePasswordIcon.classList.add('fa-eye-slash');
                } else {
                    togglePasswordIcon.classList.remove('fa-eye-slash');
                    togglePasswordIcon.classList.add('fa-eye');
                }
            });
        }
    </script>
</body>

</html>
