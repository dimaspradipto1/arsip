<!-- Statistik SK Pribadi Dosen -->
<div class="row g-3 mb-4">
  <!-- SK Pengajaran -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm h-100 hover-card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">SK Pengajaran</p>
            <h4 class="font-weight-bolder mb-0 text-dark">{{ $skPengajaranCount ?? 0 }}</h4>
          </div>
          <div class="icon icon-shape bg-primary text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
            <i class="fas fa-chalkboard-teacher fs-6"></i>
          </div>
        </div>
        <div class="mt-2 pt-2 border-top">
          <a href="{{ route('skpengajaran.index') }}" class="text-xs text-primary font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
            <span>Buka Data SK</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- SK Pembimbing Tugas Akhir -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm h-100 hover-card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Pembimbing TA</p>
            <h4 class="font-weight-bolder mb-0 text-dark">{{ $skTaCount ?? 0 }}</h4>
          </div>
          <div class="icon icon-shape bg-info text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
            <i class="fas fa-user-graduate fs-6"></i>
          </div>
        </div>
        <div class="mt-2 pt-2 border-top">
          <a href="{{ route('skpembimbingtugasakhir.index') }}" class="text-xs text-info font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
            <span>Buka Data SK</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- SK Penguji Sempro -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm h-100 hover-card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Penguji Sempro</p>
            <h4 class="font-weight-bolder mb-0 text-dark">{{ $skSemproCount ?? 0 }}</h4>
          </div>
          <div class="icon icon-shape bg-warning text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
            <i class="fas fa-clipboard-check fs-6"></i>
          </div>
        </div>
        <div class="mt-2 pt-2 border-top">
          <a href="{{ route('skpengujisempro.index') }}" class="text-xs text-warning font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
            <span>Buka Data SK</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- SK Penguji Tugas Akhir -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm h-100 hover-card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Penguji Sidang TA</p>
            <h4 class="font-weight-bolder mb-0 text-dark">{{ $skPengujiTaCount ?? 0 }}</h4>
          </div>
          <div class="icon icon-shape bg-danger text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
            <i class="fas fa-medal fs-6"></i>
          </div>
        </div>
        <div class="mt-2 pt-2 border-top">
          <a href="{{ route('skpengujitugasakhir.index') }}" class="text-xs text-danger font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
            <span>Buka Data SK</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- SK Pembimbing KPM -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm h-100 hover-card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Pembimbing KPM</p>
            <h4 class="font-weight-bolder mb-0 text-dark">{{ $skKpmCount ?? 0 }}</h4>
          </div>
          <div class="icon icon-shape bg-success text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
            <i class="fas fa-users fs-6"></i>
          </div>
        </div>
        <div class="mt-2 pt-2 border-top">
          <a href="{{ route('skpembimbingkpm.index') }}" class="text-xs text-success font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
            <span>Buka Data SK</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- SK Pembimbing Akademik (PA) -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm h-100 hover-card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Pembimbing Akademik</p>
            <h4 class="font-weight-bolder mb-0 text-dark">{{ $skPaCount ?? 0 }}</h4>
          </div>
          <div class="icon icon-shape bg-dark text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
            <i class="fas fa-user-check fs-6"></i>
          </div>
        </div>
        <div class="mt-2 pt-2 border-top">
          <a href="{{ route('skpembimbingakademik.index') }}" class="text-xs text-dark font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
            <span>Buka Data SK</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- SK Jabatan Struktural -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm h-100 hover-card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Jabatan Struktural</p>
            <h4 class="font-weight-bolder mb-0 text-dark">{{ $skStrukturalCount ?? 0 }}</h4>
          </div>
          <div class="icon icon-shape text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(135deg, #6366f1, #4338ca);">
            <i class="fas fa-id-badge fs-6"></i>
          </div>
        </div>
        <div class="mt-2 pt-2 border-top">
          <a href="{{ route('skpengangkatanstruktural.index') }}" class="text-xs text-primary font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
            <span>Buka Data SK</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Karya & Penelitian -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm h-100 hover-card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Buku & HKI</p>
            <h4 class="font-weight-bolder mb-0 text-dark">{{ ($bukuCount ?? 0) + ($hkiCount ?? 0) }}</h4>
          </div>
          <div class="icon icon-shape bg-info text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
            <i class="fas fa-book fs-6"></i>
          </div>
        </div>
        <div class="mt-2 pt-2 border-top">
          <a href="{{ route('buku.index') }}" class="text-xs text-info font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
            <span>Buka Data Buku</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Navigasi Cepat Arsip Dosen -->
<div class="row mb-4">
  <div class="col-12">
    <div class="card border-0 shadow-sm border-radius-lg">
      <div class="card-header pb-0 p-3 bg-transparent d-flex justify-content-between align-items-center">
        <h6 class="font-weight-bolder mb-0 text-dark">
          <i class="fas fa-folder-open text-primary me-2"></i>Daftar Berkas & Dokumen Terkait Anda
        </h6>
      </div>
      <div class="card-body p-3">
        <div class="row g-2 g-md-3">
          <div class="col-6 col-md-3">
            <a href="{{ route('skpengajaran.index') }}" class="btn btn-outline-primary w-100 text-start d-flex align-items-center justify-content-between p-3 mb-0 rounded-3">
              <div>
                <i class="fas fa-chalkboard-teacher me-2"></i>
                <span class="font-weight-bold text-xs">SK Pengajaran</span>
              </div>
              <span class="badge bg-primary text-white rounded-pill">{{ $skPengajaranCount ?? 0 }}</span>
            </a>
          </div>
          <div class="col-6 col-md-3">
            <a href="{{ route('skpembimbingtugasakhir.index') }}" class="btn btn-outline-info w-100 text-start d-flex align-items-center justify-content-between p-3 mb-0 rounded-3">
              <div>
                <i class="fas fa-user-graduate me-2"></i>
                <span class="font-weight-bold text-xs">Pembimbing TA</span>
              </div>
              <span class="badge bg-info text-white rounded-pill">{{ $skTaCount ?? 0 }}</span>
            </a>
          </div>
          <div class="col-6 col-md-3">
            <a href="{{ route('skpengujisempro.index') }}" class="btn btn-outline-warning w-100 text-start d-flex align-items-center justify-content-between p-3 mb-0 rounded-3">
              <div>
                <i class="fas fa-clipboard-check me-2"></i>
                <span class="font-weight-bold text-xs">Penguji Sempro</span>
              </div>
              <span class="badge bg-warning text-dark rounded-pill">{{ $skSemproCount ?? 0 }}</span>
            </a>
          </div>
          <div class="col-6 col-md-3">
            <a href="{{ route('skpengujitugasakhir.index') }}" class="btn btn-outline-danger w-100 text-start d-flex align-items-center justify-content-between p-3 mb-0 rounded-3">
              <div>
                <i class="fas fa-medal me-2"></i>
                <span class="font-weight-bold text-xs">Penguji Sidang</span>
              </div>
              <span class="badge bg-danger text-white rounded-pill">{{ $skPengujiTaCount ?? 0 }}</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
