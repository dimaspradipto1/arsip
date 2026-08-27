@extends('layouts.dashboard.template')

@section('title', $isDosen ? 'Dashboard Dosen' : 'Dashboard Utama')

@php
    $sections = [
        ['id' => 'table-bidang-pendidikan', 'title' => 'Bidang Pendidikan', 'items' => $bidangPendidikan],
        ['id' => 'table-bidang-penelitian', 'title' => 'Bidang Penelitian', 'items' => $bidangPenelitian],
        ['id' => 'table-bidang-pengabdian', 'title' => 'Bidang Pengabdian', 'items' => $bidangPengabdian],
        ['id' => 'table-penunjang', 'title' => 'Penunjang', 'items' => $penunjang],
    ];
@endphp

@section('content')
<div class="container-fluid py-3">

@if($isDosen)
  {{-- ========================================================================= --}}
  {{-- TAMPILAN KHUSUS DASHBOARD DOSEN --}}
  {{-- ========================================================================= --}}

  <!-- Welcome Banner Dosen -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #046B26 0%, #0db846 100%); border-radius: 16px;">
        <div class="card-body p-4 text-white">
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
              <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background: rgba(255, 255, 255, 0.2);">
                <i class="fas fa-chalkboard-teacher text-white"></i>
                <span class="text-xs font-weight-bold text-white text-uppercase" style="letter-spacing: 0.5px;">Portal Dosen FST</span>
              </div>
              <h4 class="text-white font-weight-bolder mb-1">Selamat Datang, {{ Auth::user()->name }}</h4>
              <p class="text-white text-sm mb-0" style="opacity: 0.88;">
                Dashboard ini menampilkan rekapitulasi data arsip dan Surat Keputusan (SK) resmi yang diterbitkan untuk Anda.
              </p>
            </div>
            <div class="d-flex flex-wrap gap-2 align-items-center">
              <span class="badge bg-white text-dark px-3 py-2 text-xs font-weight-bold rounded-3">
                <i class="fas fa-university me-1 text-success"></i> {{ Auth::user()->fakultas ?? 'Universitas Ibnu Sina' }}
              </span>
              <span class="badge bg-white text-dark px-3 py-2 text-xs font-weight-bold rounded-3">
                <i class="fas fa-graduation-cap me-1 text-primary"></i> {{ Auth::user()->homebase ?? 'Fakultas Sains dan Teknologi' }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistik SK Pribadi Dosen -->
  <div class="row g-3 mb-4">
    <!-- SK Pengajaran -->
    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100 hover-card">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">SK Pengajaran</p>
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skPengajaranCount }}</h4>
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
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skTaCount }}</h4>
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
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skSemproCount }}</h4>
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
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skPengujiTaCount }}</h4>
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
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skKpmCount }}</h4>
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
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skPaCount }}</h4>
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
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skStrukturalCount }}</h4>
            </div>
            <div class="icon icon-shape bg-secondary text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
              <i class="fas fa-building-columns fs-6"></i>
            </div>
          </div>
          <div class="mt-2 pt-2 border-top">
            <a href="{{ route('skpengangkatanstruktural.index') }}" class="text-xs text-secondary font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
              <span>Buka Data SK</span>
              <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Dokumen SK -->
    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100 hover-card bg-light">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Total SK Anda</p>
              <h4 class="font-weight-bolder mb-0 text-success">{{ $totalDokumenPelaksanaan }}</h4>
            </div>
            <div class="icon icon-shape bg-success text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
              <i class="fas fa-folder-open fs-6"></i>
            </div>
          </div>
          <div class="mt-2 pt-2 border-top text-xs text-muted">
            Rekapitulasi seluruh SK resmi Anda
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section 1: Data Penelitian / Identitas Karya Ilmiah (Tabel) -->
  <div class="row mb-4">
    <div class="col-12">
      <h6 class="mb-3 font-weight-bold text-dark"><i class="fas fa-book-bookmark me-2 text-success"></i>Data Penelitian / Identitas Karya Ilmiah</h6>
      <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body pt-3">
          <div class="table-responsive">
            <table id="table-identitas-karya-ilmiah-dosen" class="table table-bordered excel-table doc-table align-items-center mb-0" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center" style="width:50px">No</th>
                  <th class="text-center" style="width:70px">Tahun</th>
                  <th>Judul Karya Ilmiah</th>
                  <th>Nama Jurnal</th>
                  <th>Nomor ISSN</th>
                  <th>Volume, Nomor, Tahun</th>
                  <th>DOI Artikel</th>
                  <th>Alamat Web</th>
                  <th class="text-center">Indexing</th>
                  <th class="text-center">Kategori Publikasi</th>
                </tr>
              </thead>
              <tbody>
                @if($karyaIlmiahData->count() > 0)
                  @foreach($karyaIlmiahData as $idx => $item)
                    <tr>
                      <td class="text-center font-weight-bold">{{ $idx + 1 }}</td>
                      <td class="text-center">{{ $item->tahun }}</td>
                      <td class="font-weight-bold text-dark">{{ $item->judul_karya_ilmiah }}</td>
                      <td>{{ $item->nama_jurnal }}</td>
                      <td>{{ $item->nomor_issn }}</td>
                      <td>{{ $item->volume_nomor_tahun }}</td>
                      <td>{{ $item->doi_artikel }}</td>
                      <td>{{ $item->alamat_web }}</td>
                      <td class="text-center">{{ $item->indexing }}</td>
                      <td class="text-center">{{ $item->kategori_publikasi }}</td>
                    </tr>
                  @endforeach
                @else
                  @for ($i = 1; $i <= 10; $i++)
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  @endfor
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Section 2: Rekapitulasi Data Publikasi Ilmiah (Tabel) -->
      <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-white pb-0 border-bottom">
          <h6 class="mb-2 font-weight-bold text-dark">Rekapitulasi Data Publikasi Ilmiah</h6>
        </div>
        <div class="card-body pt-3">
          <div class="table-responsive">
            <table class="table table-bordered excel-table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center">Tahun</th>
                  <th class="text-center">JNTT</th>
                  <th class="text-center">JNT</th>
                  <th class="text-center">JT</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rekapPublikasi as $row)
                  <tr>
                    <td class="text-center">{{ $row['tahun'] }}</td>
                    <td class="text-center">{{ $row['jntt'] }}</td>
                    <td class="text-center">{{ $row['jnt'] }}</td>
                    <td class="text-center">{{ $row['jt'] }}</td>
                  </tr>
                @endforeach
                <tr class="fw-bold bg-light">
                  <td class="text-center">JUMLAH</td>
                  <td class="text-center">{{ collect($rekapPublikasi)->sum('jntt') }}</td>
                  <td class="text-center">{{ collect($rekapPublikasi)->sum('jnt') }}</td>
                  <td class="text-center">{{ collect($rekapPublikasi)->sum('jt') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Rekapitulasi Dokumen Tridharma Dosen -->
  <div class="row">
    <div class="col-12">
      <h6 class="mb-3 font-weight-bold text-dark"><i class="fas fa-list-check me-2 text-success"></i>Rekapitulasi Dokumen Pelaksanaan Pendidikan (Tridharma Pribadi)</h6>

      @foreach ($sections as $section)
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-header bg-white pb-0 border-bottom">
            <h6 class="mb-2 font-weight-bold text-dark">{{ $section['title'] }}</h6>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-items-center mb-0" style="width:100%">
                <thead class="bg-light">
                  <tr>
                    <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:60px">No</th>
                    <th class="text-secondary text-xxs font-weight-bolder opacity-7">Nama Dokumen / Kategori SK</th>
                    <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:140px">Jumlah Data Anda</th>
                    <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:140px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($section['items'] as $i => $item)
                    <tr>
                      <td class="text-center text-xs font-weight-bold">{{ $i + 1 }}</td>
                      <td class="text-xs font-weight-bold text-dark">{{ $item['nama'] }}</td>
                      <td class="text-center">
                        @if($item['count'] > 0)
                          <span class="badge bg-success text-white px-2 py-1 text-xs font-weight-bold">{{ $item['count'] }} Data</span>
                        @else
                          <span class="text-muted text-xs">0 Data</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if(!empty($item['route']))
                          <a href="{{ $item['route'] }}" class="btn btn-xs btn-outline-success mb-0 px-3 py-1">
                            <i class="fas fa-eye me-1"></i> Buka Menu
                          </a>
                        @else
                          <span class="text-muted text-xxs">-</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endforeach

      <!-- Section 3: Rekapitulasi Kategori SK Kepanitiaan (Tabel) -->
      <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-white pb-0 border-bottom d-flex align-items-center justify-content-between">
          <h6 class="mb-2 font-weight-bold text-dark"><i class="fas fa-tags me-2 text-danger"></i>Rekapitulasi Kategori SK Kepanitiaan</h6>
          <a href="{{ route('skkepanitiaan.index') }}" class="btn btn-xs btn-outline-danger mb-2">
            <i class="fas fa-eye me-1"></i> Buka SK Kepanitiaan
          </a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-items-center mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:60px">No</th>
                  <th class="text-secondary text-xxs font-weight-bolder opacity-7">Nama Kategori SK Kepanitiaan</th>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:160px">Jumlah Dokumen</th>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:140px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($kategoriSkList as $idx => $kat)
                  <tr>
                    <td class="text-center text-xs font-weight-bold">{{ $idx + 1 }}</td>
                    <td class="text-xs font-weight-bold text-dark">{{ $kat->kategory_sk }}</td>
                    <td class="text-center">
                      <span class="badge {{ $kat->skkepanitiaan_count > 0 ? 'bg-primary' : 'bg-light text-secondary' }} text-xs font-weight-bold px-2 py-1">
                        {{ $kat->skkepanitiaan_count }} Dokumen
                      </span>
                    </td>
                    <td class="text-center">
                      <a href="{{ route('skkepanitiaan.index') }}" class="btn btn-xs btn-outline-danger mb-0 px-3 py-1">
                        <i class="fas fa-folder-open me-1"></i> Lihat SK
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>

@else
  {{-- ========================================================================= --}}
  {{-- TAMPILAN DASHBOARD ADMIN / TATA USAHA / DEKAN / KAPRODI --}}
  {{-- ========================================================================= --}}

  <!-- Welcome Banner Admin/TU -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border-radius: 16px;">
        <div class="card-body p-4 text-white">
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
              <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background: rgba(255, 255, 255, 0.15);">
                <i class="fas fa-shield-alt text-warning"></i>
                <span class="text-xs font-weight-bold text-white text-uppercase" style="letter-spacing: 0.5px;">Panel Administrasi & Tata Usaha</span>
              </div>
              <h4 class="text-white font-weight-bolder mb-1">Selamat Datang, {{ Auth::user()->name }}</h4>
              <p class="text-white text-sm mb-0" style="opacity: 0.88;">
                Pusat data arsip digital, pemantauan dokumen resmi, dan rekapitulasi Surat Keputusan Fakultas Sains dan Teknologi.
              </p>
            </div>
            <div class="d-flex flex-wrap gap-2 align-items-center">
              <span class="badge bg-primary text-white px-3 py-2 text-xs font-weight-bold rounded-3">
                <i class="fas fa-users me-1"></i> {{ $totalDosen }} Dosen Terdaftar
              </span>
              <span class="badge bg-success text-white px-3 py-2 text-xs font-weight-bold rounded-3">
                <i class="fas fa-file-signature me-1"></i> {{ $totalDokumenPelaksanaan }} Total Arsip SK
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Aksi Cepat / Shortcut Tata Usaha & Admin -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm p-3" style="border-radius: 14px;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
          <div class="d-flex align-items-center gap-2">
            <div class="icon icon-shape bg-warning text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="fas fa-bolt text-xs"></i>
            </div>
            <div>
              <h6 class="mb-0 text-sm font-weight-bold text-dark">Aksi Cepat / Tambah Data Baru</h6>
              <span class="text-xxs text-secondary">Shortcut langsung untuk input arsip dan SK baru</span>
            </div>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('skpengajaran.create') }}" class="btn btn-xs btn-primary mb-0 d-inline-flex align-items-center gap-1">
              <i class="fas fa-plus"></i> SK Pengajaran
            </a>
            <a href="{{ route('skpembimbingtugasakhir.create') }}" class="btn btn-xs btn-info text-white mb-0 d-inline-flex align-items-center gap-1">
              <i class="fas fa-plus"></i> SK Pembimbing TA
            </a>
            <a href="{{ route('skpengujisempro.create') }}" class="btn btn-xs btn-warning text-white mb-0 d-inline-flex align-items-center gap-1">
              <i class="fas fa-plus"></i> SK Penguji Sempro
            </a>
            <a href="{{ route('skkepanitiaan.create') }}" class="btn btn-xs btn-danger mb-0 d-inline-flex align-items-center gap-1">
              <i class="fas fa-plus"></i> SK Kepanitiaan
            </a>
            @if(Auth::user()->roles === 'admin')
              <a href="{{ route('user.create') }}" class="btn btn-xs btn-dark mb-0 d-inline-flex align-items-center gap-1">
                <i class="fas fa-user-plus"></i> Tambah User
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistik Global Admin (Stat Cards) -->
  <div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100 hover-card">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">SK Pengajaran</p>
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skPengajaranCount }}</h4>
            </div>
            <div class="icon icon-shape bg-primary text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
              <i class="fas fa-chalkboard-teacher fs-6"></i>
            </div>
          </div>
          <div class="mt-2 pt-2 border-top">
            <a href="{{ route('skpengajaran.index') }}" class="text-xs text-primary font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
              <span>Kelola SK</span>
              <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100 hover-card">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Total SK Pembimbing</p>
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skTaCount + $skKpmCount + $skPaCount }}</h4>
            </div>
            <div class="icon icon-shape bg-info text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
              <i class="fas fa-user-graduate fs-6"></i>
            </div>
          </div>
          <div class="mt-2 pt-2 border-top">
            <a href="{{ route('skpembimbingtugasakhir.index') }}" class="text-xs text-info font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
              <span>Kelola SK</span>
              <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100 hover-card">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Total SK Penguji</p>
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skSemproCount + $skPengujiTaCount }}</h4>
            </div>
            <div class="icon icon-shape bg-warning text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
              <i class="fas fa-clipboard-check fs-6"></i>
            </div>
          </div>
          <div class="mt-2 pt-2 border-top">
            <a href="{{ route('skpengujisempro.index') }}" class="text-xs text-warning font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
              <span>Kelola SK</span>
              <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm h-100 hover-card">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">SK Kepanitiaan</p>
              <h4 class="font-weight-bolder mb-0 text-dark">{{ $skPanitiaCount }}</h4>
            </div>
            <div class="icon icon-shape bg-danger text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
              <i class="fas fa-tasks fs-6"></i>
            </div>
          </div>
          <div class="mt-2 pt-2 border-top">
            <a href="{{ route('skkepanitiaan.index') }}" class="text-xs text-danger font-weight-bold text-decoration-none d-flex align-items-center justify-content-between">
              <span>Kelola SK</span>
              <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Visual Graphs / Charts Admin & Tata Usaha -->
  <div class="row g-4 mb-4">
    <!-- Chart 1: Bar Chart Volume SK -->
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
        <div class="card-header bg-white pb-0 border-bottom d-flex align-items-center justify-content-between">
          <div>
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-chart-column me-2 text-primary"></i>Statistik Volume Dokumen per Jenis SK</h6>
            <p class="text-xxs text-secondary mb-2">Perbandingan jumlah Surat Keputusan terbit antar kategori</p>
          </div>
          <span class="badge bg-light text-dark text-xxs font-weight-bold">Fakultas Sains & Teknologi</span>
        </div>
        <div class="card-body p-3">
          <div class="chart-container" style="position: relative; height: 270px; width: 100%;">
            <canvas id="adminSkBarChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart 2: Doughnut Chart Komposisi SK -->
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
        <div class="card-header bg-white pb-0 border-bottom d-flex align-items-center justify-content-between">
          <div>
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-chart-pie me-2 text-info"></i>Komposisi Arsip SK</h6>
            <p class="text-xxs text-secondary mb-2">Proporsi arsip berdasarkan bidang tugas</p>
          </div>
          <span class="badge bg-success text-white text-xxs font-weight-bold">{{ $totalDokumenPelaksanaan }} Total</span>
        </div>
        <div class="card-body p-3">
          <div class="chart-container" style="position: relative; height: 270px; width: 100%;">
            <canvas id="adminSkDoughnutChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Aktivitas SK Terkini & Rekapitulasi -->
  <div class="row g-4 mb-4">
    <!-- Tabel Input SK Terkini -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
        <div class="card-header bg-white pb-0 border-bottom d-flex align-items-center justify-content-between">
          <h6 class="mb-2 font-weight-bold text-dark"><i class="fas fa-clock-rotate-left me-2 text-warning"></i>Aktivitas SK Terbaru</h6>
          <span class="badge bg-light text-secondary text-xxs">Terakhir Diunggah</span>
        </div>
        <div class="card-body p-0">
          @if($recentSks->count() > 0)
            <div class="table-responsive">
              <table class="table table-hover align-items-center mb-0">
                <thead class="bg-light">
                  <tr>
                    <th class="text-secondary text-xxs font-weight-bolder opacity-7">Jenis SK & Nomor</th>
                    <th class="text-secondary text-xxs font-weight-bolder opacity-7">Dosen / Penerima</th>
                    <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($recentSks as $rSk)
                    <tr>
                      <td class="text-xs">
                        <span class="badge {{ $rSk['badge_bg'] }} mb-1" style="font-size: 9px; padding: 2px 6px;">{{ $rSk['type'] }}</span>
                        <div class="font-weight-bold text-dark text-truncate" style="max-width: 180px;">No: {{ $rSk['nomor_sk'] ?? '-' }}</div>
                        <span class="text-xxs text-muted">TA: {{ $rSk['tahun'] }}</span>
                      </td>
                      <td class="text-xs text-dark font-weight-bold text-truncate" style="max-width: 160px;">
                        {{ $rSk['dosen'] }}
                      </td>
                      <td class="text-center">
                        <a href="{{ $rSk['route'] }}" class="btn btn-xs btn-outline-primary mb-0 px-2 py-1" title="Buka Menu">
                          <i class="fas fa-eye"></i>
                        </a>
                        @if(!empty($rSk['dokumen']))
                          <a href="{{ $rSk['dokumen'] }}" target="_blank" class="btn btn-xs btn-outline-success mb-0 px-2 py-1" title="Lihat Dokumen">
                            <i class="fas fa-file-pdf"></i>
                          </a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="p-4 text-center text-muted text-xs">
              <i class="fas fa-folder-open fs-4 d-block mb-2 text-secondary opacity-5"></i>
              Belum ada data SK terbaru yang tercatat.
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Ringkasan Cepat Dokumen Pendukung -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
        <div class="card-header bg-white pb-0 border-bottom d-flex align-items-center justify-content-between">
          <h6 class="mb-2 font-weight-bold text-dark"><i class="fas fa-file-shield me-2 text-success"></i>Dokumen Pendukung Institusi</h6>
          <span class="badge bg-light text-secondary text-xxs">Arsip Kepegawaian</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-items-center mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:50px">No</th>
                  <th class="text-secondary text-xxs font-weight-bolder opacity-7">Nama Dokumen Pendukung</th>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:120px">Status Arsip</th>
                </tr>
              </thead>
              <tbody>
                @foreach (array_slice($dokumenPendukung, 0, 6) as $row)
                  <tr>
                    <td class="text-center text-xs font-weight-bold">{{ $row['no'] }}</td>
                    <td class="text-xs font-weight-bold text-dark">{{ $row['nama'] }}</td>
                    <td class="text-center">
                      <span class="badge {{ $row['count'] > 0 ? 'bg-success text-white' : 'bg-light text-secondary' }} text-xxs px-2 py-1">
                        {{ $row['count'] > 0 ? $row['count'] . ' Berkas' : '0 Berkas' }}
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section: Data Penelitian & Identitas Karya Ilmiah (Tabel) -->
  <div class="row mb-4">
    <div class="col-12">
      <h6 class="mb-3 font-weight-bold text-dark"><i class="fas fa-book-bookmark me-2 text-success"></i>Data Penelitian / Identitas Karya Ilmiah</h6>
      <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body pt-3">
          <div class="table-responsive">
            <table id="table-identitas-karya-ilmiah-admin" class="table table-bordered excel-table doc-table align-items-center mb-0" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center" style="width:50px">No</th>
                  <th class="text-center" style="width:70px">Tahun</th>
                  <th>Judul Karya Ilmiah</th>
                  <th>Nama Jurnal</th>
                  <th>Nomor ISSN</th>
                  <th>Volume, Nomor, Tahun</th>
                  <th>DOI Artikel</th>
                  <th>Alamat Web</th>
                  <th class="text-center">Indexing</th>
                  <th class="text-center">Kategori Publikasi</th>
                </tr>
              </thead>
              <tbody>
                @if($karyaIlmiahData->count() > 0)
                  @foreach($karyaIlmiahData as $idx => $item)
                    <tr>
                      <td class="text-center font-weight-bold">{{ $idx + 1 }}</td>
                      <td class="text-center">{{ $item->tahun }}</td>
                      <td class="font-weight-bold text-dark">{{ $item->judul_karya_ilmiah }}</td>
                      <td>{{ $item->nama_jurnal }}</td>
                      <td>{{ $item->nomor_issn }}</td>
                      <td>{{ $item->volume_nomor_tahun }}</td>
                      <td>{{ $item->doi_artikel }}</td>
                      <td>{{ $item->alamat_web }}</td>
                      <td class="text-center">{{ $item->indexing }}</td>
                      <td class="text-center">{{ $item->kategori_publikasi }}</td>
                    </tr>
                  @endforeach
                @else
                  @for ($i = 1; $i <= 10; $i++)
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  @endfor
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Rekapitulasi Data Publikasi Ilmiah (Admin) -->
      <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-white pb-0 border-bottom">
          <h6 class="mb-2 font-weight-bold text-dark">Rekapitulasi Data Publikasi Ilmiah</h6>
        </div>
        <div class="card-body pt-3">
          <div class="table-responsive">
            <table class="table table-bordered excel-table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center">Tahun</th>
                  <th class="text-center">JNTT</th>
                  <th class="text-center">JNT</th>
                  <th class="text-center">JT</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rekapPublikasi as $row)
                  <tr>
                    <td class="text-center">{{ $row['tahun'] }}</td>
                    <td class="text-center">{{ $row['jntt'] }}</td>
                    <td class="text-center">{{ $row['jnt'] }}</td>
                    <td class="text-center">{{ $row['jt'] }}</td>
                  </tr>
                @endforeach
                <tr class="fw-bold bg-light">
                  <td class="text-center">JUMLAH</td>
                  <td class="text-center">{{ collect($rekapPublikasi)->sum('jntt') }}</td>
                  <td class="text-center">{{ collect($rekapPublikasi)->sum('jnt') }}</td>
                  <td class="text-center">{{ collect($rekapPublikasi)->sum('jt') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Section: Rekapitulasi Kategori SK Kepanitiaan (Tabel Admin) -->
      <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-white pb-0 border-bottom d-flex align-items-center justify-content-between">
          <h6 class="mb-2 font-weight-bold text-dark"><i class="fas fa-tags me-2 text-danger"></i>Rekapitulasi Kategori SK Kepanitiaan</h6>
          <a href="{{ route('skkepanitiaan.index') }}" class="btn btn-xs btn-outline-danger mb-2">
            <i class="fas fa-eye me-1"></i> Buka SK Kepanitiaan
          </a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-items-center mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:60px">No</th>
                  <th class="text-secondary text-xxs font-weight-bolder opacity-7">Nama Kategori SK Kepanitiaan</th>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:160px">Jumlah Dokumen</th>
                  <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:140px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($kategoriSkList as $idx => $kat)
                  <tr>
                    <td class="text-center text-xs font-weight-bold">{{ $idx + 1 }}</td>
                    <td class="text-xs font-weight-bold text-dark">{{ $kat->kategory_sk }}</td>
                    <td class="text-center">
                      <span class="badge {{ $kat->skkepanitiaan_count > 0 ? 'bg-primary' : 'bg-light text-secondary' }} text-xs font-weight-bold px-2 py-1">
                        {{ $kat->skkepanitiaan_count }} Dokumen
                      </span>
                    </td>
                    <td class="text-center">
                      <a href="{{ route('skkepanitiaan.index') }}" class="btn btn-xs btn-outline-danger mb-0 px-3 py-1">
                        <i class="fas fa-folder-open me-1"></i> Lihat SK
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Overview Dokumen Pelaksanaan Tridharma Pendidikan Global -->
  <div class="row">
    <div class="col-12">
      <h6 class="mb-3 font-weight-bold text-dark"><i class="fas fa-folder-tree me-2 text-primary"></i>Dokumen Pelaksanaan Pendidikan (Seluruh Fakultas)</h6>

      @foreach ($sections as $section)
        <div class="card mb-4 border-0 shadow-sm" style="border-radius: 14px;">
          <div class="card-header bg-white pb-0 border-bottom">
            <h6 class="mb-2 font-weight-bold text-dark">{{ $section['title'] }}</h6>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-items-center mb-0" style="width:100%">
                <thead class="bg-light">
                  <tr>
                    <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:60px">No</th>
                    <th class="text-secondary text-xxs font-weight-bolder opacity-7">Nama Dokumen</th>
                    <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:140px">Jumlah Data</th>
                    <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width:140px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($section['items'] as $i => $item)
                    <tr>
                      <td class="text-center text-xs font-weight-bold">{{ $i + 1 }}</td>
                      <td class="text-xs font-weight-bold text-dark">{{ $item['nama'] }}</td>
                      <td class="text-center">
                        <span class="badge {{ $item['count'] > 0 ? 'bg-primary' : 'bg-light text-dark' }} text-xs font-weight-bold px-2 py-1">
                          {{ $item['count'] }} Data
                        </span>
                      </td>
                      <td class="text-center">
                        @if(!empty($item['route']))
                          <a href="{{ $item['route'] }}" class="btn btn-xs btn-outline-primary mb-0 px-3 py-1">
                            <i class="fas fa-folder-open me-1"></i> Buka Data
                          </a>
                        @else
                          <span class="text-muted text-xxs">-</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>
@endif

  <!-- Footer -->
  <footer class="footer pt-3">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="copyright text-center text-xs text-muted text-lg-start">
            © <script>
              document.write(new Date().getFullYear())
            </script>, Sistem E-Arsip Fakultas Sains dan Teknologi Universitas Ibnu Sina
          </div>
        </div>
      </div>
    </div>
  </footer>
</div>

<style>
  .hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 12px;
  }
  .hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
  }
  .excel-table th {
    background-color: #f8f9fa;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
  }
  .excel-table td,
  .excel-table th {
    border-color: #dee2e6;
    font-size: 0.75rem;
    padding: 0.4rem 0.6rem;
  }
</style>
@endsection

@push('script')
<script>
  $(function () {
    if ($.fn.DataTable) {
      $('.doc-table').each(function () {
        if (!$.fn.DataTable.isDataTable(this)) {
          $(this).DataTable({
            scrollX: true,
            pageLength: 10,
            autoWidth: false,
            language: {
              search: 'Cari:',
              searchPlaceholder: 'Ketik pencarian...',
              lengthMenu: '_MENU_ per halaman',
              info: 'Menampilkan _START_ s/d _END_ dari _TOTAL_ entri',
              infoEmpty: 'Tidak ada data',
              zeroRecords: 'Data tidak ditemukan',
              paginate: {
                first: '«',
                previous: '‹',
                next: '›',
                last: '»'
              }
            }
          });
        }
      });
    }
  });
</script>

@if(!$isDosen)
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // 1. Bar Chart Volume SK
    var barEl = document.getElementById('adminSkBarChart');
    if (barEl) {
      new Chart(barEl.getContext('2d'), {
        type: 'bar',
        data: {
          labels: {!! json_encode($chartSkLabels) !!},
          datasets: [{
            label: 'Jumlah Surat Keputusan',
            data: {!! json_encode($chartSkData) !!},
            backgroundColor: [
              '#3b82f6', // Pengajaran (Blue)
              '#06b6d4', // Pembimbing TA (Cyan)
              '#f59e0b', // Penguji Sempro (Amber)
              '#ef4444', // Penguji TA (Red)
              '#10b981', // Bimbingan KPM (Emerald)
              '#6366f1', // Bimbingan PA (Indigo)
              '#64748b', // Struktural (Slate)
              '#ec4899'  // Kepanitiaan (Pink)
            ],
            borderRadius: 6,
            borderSkipped: false,
            maxBarThickness: 32
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return ' ' + context.raw + ' Dokumen SK';
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                precision: 0,
                stepSize: 1,
                font: { size: 11 }
              },
              grid: {
                color: '#f1f5f9',
                drawBorder: false
              }
            },
            x: {
              ticks: {
                font: { size: 10 }
              },
              grid: { display: false }
            }
          }
        }
      });
    }

    // 2. Doughnut Chart Komposisi SK
    var doughnutEl = document.getElementById('adminSkDoughnutChart');
    if (doughnutEl) {
      new Chart(doughnutEl.getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: {!! json_encode($chartSkLabels) !!},
          datasets: [{
            data: {!! json_encode($chartSkData) !!},
            backgroundColor: [
              '#3b82f6',
              '#06b6d4',
              '#f59e0b',
              '#ef4444',
              '#10b981',
              '#6366f1',
              '#64748b',
              '#ec4899'
            ],
            borderWidth: 2,
            borderColor: '#ffffff',
            hoverOffset: 6
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                boxWidth: 10,
                font: { size: 9.5 },
                padding: 8
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  var total = context.dataset.data.reduce(function(a, b) { return a + b; }, 0);
                  var val = context.raw;
                  var pct = total > 0 ? ((val / total) * 100).toFixed(1) + '%' : '0%';
                  return ' ' + context.label + ': ' + val + ' SK (' + pct + ')';
                }
              }
            }
          },
          cutout: '65%'
        }
      });
    }
  });
</script>
@endif
@endpush
