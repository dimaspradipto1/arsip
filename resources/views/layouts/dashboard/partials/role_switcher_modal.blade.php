@php
    $authUser = Auth::user();
    $userRoles = $authUser ? $authUser->roles : [];
    $activeRole = $authUser ? $authUser->getActiveRole() : '';
    $hasMultipleRoles = count($userRoles) > 1;
    $mustChooseRole = $hasMultipleRoles && !session()->has('active_role');

    $roleDefinitions = [
        'admin' => [
            'name' => 'Administrator',
            'title' => 'Portal Admin',
            'subtitle' => 'Kelola Seluruh Pengguna & Arsip',
            'icon' => 'fas fa-shield-halved',
            'icon_color' => '#dc2626',
            'bg_icon' => '#fee2e2',
            'accent' => '#dc2626',
            'badge' => 'bg-danger'
        ],
        'dekan' => [
            'name' => 'Dekan',
            'title' => 'Portal Dekan',
            'subtitle' => 'Monitoring Eksekutif Fakultas',
            'icon' => 'fas fa-crown',
            'icon_color' => '#059669',
            'bg_icon' => '#d1fae5',
            'accent' => '#059669',
            'badge' => 'bg-success'
        ],
        'wakilDekan1' => [
            'name' => 'Wakil Dekan 1',
            'title' => 'Portal WD 1 (Akademik)',
            'subtitle' => 'Bidang Akademik & Kurikulum',
            'icon' => 'fas fa-book-open-reader',
            'icon_color' => '#2563eb',
            'bg_icon' => '#dbeafe',
            'accent' => '#2563eb',
            'badge' => 'bg-info'
        ],
        'wakilDekan2' => [
            'name' => 'Wakil Dekan 2',
            'title' => 'Portal WD 2 (SDM/Umum)',
            'subtitle' => 'Bidang Umum & Kepegawaian',
            'icon' => 'fas fa-briefcase',
            'icon_color' => '#d97706',
            'bg_icon' => '#fef3c7',
            'accent' => '#d97706',
            'badge' => 'bg-warning'
        ],
        'kaprodi' => [
            'name' => 'Kaprodi',
            'title' => 'Portal Kaprodi',
            'subtitle' => 'Monitoring Dosen & Arsip Prodi',
            'icon' => 'fas fa-graduation-cap',
            'icon_color' => '#0d9488',
            'bg_icon' => '#ccfbf1',
            'accent' => '#0d9488',
            'badge' => 'bg-dark'
        ],
        'sekprodi' => [
            'name' => 'Sekprodi',
            'title' => 'Portal Sekprodi',
            'subtitle' => 'Operasional & Administrasi Prodi',
            'icon' => 'fas fa-file-pen',
            'icon_color' => '#475569',
            'bg_icon' => '#f1f5f9',
            'accent' => '#475569',
            'badge' => 'bg-secondary'
        ],
        'tatausaha' => [
            'name' => 'Tata Usaha',
            'title' => 'Portal Tata Usaha',
            'subtitle' => 'Penerbitan & Tata Kelola SK',
            'icon' => 'fas fa-folder-open',
            'icon_color' => '#046B26',
            'bg_icon' => '#E8F5E9',
            'accent' => '#046B26',
            'badge' => 'bg-primary'
        ],
        'dosen' => [
            'name' => 'Dosen',
            'title' => 'Portal Dosen',
            'subtitle' => 'Arsip SK & Kinerja Pribadi',
            'icon' => 'fas fa-chalkboard-teacher',
            'icon_color' => '#0284c7',
            'bg_icon' => '#e0f2fe',
            'accent' => '#0284c7',
            'badge' => 'bg-info'
        ],
    ];
@endphp

@if($hasMultipleRoles)
<!-- Modal Pemilihan Peran / Multi-Role Portal Chooser -->
<div class="modal fade" id="roleSwitcherModal" tabindex="-1" aria-labelledby="roleSwitcherModalLabel" aria-hidden="true" data-bs-backdrop="{{ $mustChooseRole ? 'static' : 'true' }}" data-bs-keyboard="{{ $mustChooseRole ? 'false' : 'true' }}" style="z-index: 1075;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-2xl overflow-hidden" style="border-radius: 20px;">

      <!-- Header Banner UIS (Sesuai Referensi Gambar) -->
      <div class="p-3 p-md-4 text-white position-relative" style="background: linear-gradient(135deg, #0b4f8a 0%, #002d62 100%);">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
          <!-- Logo & Kampus Title -->
          <div class="d-flex align-items-center gap-3">
            <div class="bg-white p-1.5 rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
              <img src="{{ asset('dashboard/assets/img/uis.png') }}" alt="Logo UIS" class="img-fluid" style="max-height: 42px;">
            </div>
            <div>
              <span class="text-xs text-white-50 text-uppercase font-weight-bold d-block" style="letter-spacing: 0.5px;">Sistem Informasi E-Arsip Digital</span>
              <h5 class="text-white font-weight-bolder mb-0 text-uppercase" style="letter-spacing: 0.8px;">Universitas Ibnu Sina</h5>
            </div>
          </div>

          <!-- Top Right Action Buttons -->
          <div class="d-flex align-items-center gap-2">
            <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-white text-white border-white px-3 py-1.5 rounded-3 mb-0 text-xs font-weight-bold d-inline-flex align-items-center gap-1.5" style="border-color: rgba(255,255,255,0.4) !important;">
              <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
            @if(!$mustChooseRole)
              <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
            @endif
          </div>
        </div>
      </div>

      <!-- Body: Grid Daftar Modul / Peran Akses -->
      <div class="modal-body p-3 p-md-4 bg-light" style="background-color: #f8fafc !important;">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h6 class="font-weight-bolder text-dark mb-0 fs-5">Daftar Modul & Hak Akses Anda</h6>
            <p class="text-xs text-muted mb-0">Silakan klik salah satu peran di bawah untuk mengaktifkan ruang kerja Anda</p>
          </div>
          <span class="badge bg-white text-dark border px-2.5 py-1.5 rounded-pill text-xs font-weight-bold shadow-none">
            {{ count($userRoles) }} Peran Tersedia
          </span>
        </div>

        <div class="row g-3">
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
                  'badge' => 'bg-secondary'
              ];
              $isActive = ($activeRole === $roleKey);
            @endphp

            <div class="col-12 col-sm-6 col-md-4">
              <a href="{{ route('switch.role.get', ['role' => $roleKey]) }}" class="card border h-100 text-decoration-none role-portal-card {{ $isActive ? 'active-role-card' : '' }}" style="border-radius: 14px; transition: all 0.25s ease; border-color: {{ $isActive ? $roleInfo['accent'] : '#e2e8f0' }} !important; background-color: #ffffff;">
                <div class="card-body p-3 text-center d-flex flex-column align-items-center justify-content-between position-relative">
                  
                  @if($isActive)
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                      <span class="badge bg-success rounded-pill px-2 py-0.5 text-xxs font-weight-bold">
                        <i class="fas fa-check me-1"></i> Aktif
                      </span>
                    </div>
                  @endif

                  <!-- Icon Box (Besar & Cantik Sesuai Referensi Gambar) -->
                  <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 mt-1 shadow-sm" style="width: 62px; height: 62px; background-color: {{ $roleInfo['bg_icon'] }};">
                    <i class="{{ $roleInfo['icon'] }} fs-3" style="color: {{ $roleInfo['icon_color'] }};"></i>
                  </div>

                  <!-- Role Title & Subtitle -->
                  <div>
                    <h6 class="font-weight-bolder text-dark mb-1 text-sm">{{ $roleInfo['title'] }}</h6>
                    <p class="text-xxs text-muted mb-0 line-clamp-2" style="min-height: 28px;">{{ $roleInfo['subtitle'] }}</p>
                  </div>

                  <div class="mt-3 w-100 pt-2 border-top">
                    <span class="btn btn-xs w-100 mb-0 font-weight-bold rounded-3 {{ $isActive ? 'btn-success text-white' : 'btn-outline-primary' }}">
                      {{ $isActive ? 'Sedang Digunakan' : 'Masuk Portal' }} <i class="fas fa-arrow-right ms-1 text-xxs"></i>
                    </span>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>

<style>
  .role-portal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important;
    border-color: #046B26 !important;
  }
  .active-role-card {
    box-shadow: 0 4px 14px rgba(4, 107, 38, 0.15) !important;
    background: #fdfefe !important;
  }
</style>

@if($mustChooseRole)
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var modalEl = document.getElementById('roleSwitcherModal');
      if (modalEl && typeof bootstrap !== 'undefined') {
        var modal = new bootstrap.Modal(modalEl, {
          backdrop: 'static',
          keyboard: false
        });
        modal.show();
      }
    });
  </script>
@endif
@endif
