@extends('layouts.dashboard.template')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <!-- Card Statistik Total Dosen Per Prodi -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card shadow-sm border-0 border-radius-lg" style="overflow: visible !important;">
                    <div class="card-body p-3 p-md-4" style="overflow: visible !important;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <!-- Left: Total Dosen Info -->
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow text-center d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px;">
                                    <i class="fas fa-chalkboard-teacher fs-5"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="font-weight-bolder mb-0 text-dark">Total Dosen</h5>
                                        <span class="badge bg-success text-white px-2.5 py-1 rounded-pill text-xs font-weight-bold">
                                            {{ $totalDosen ?? 0 }} Dosen
                                        </span>
                                    </div>
                                    <p class="text-xs text-muted mb-0 mt-0.5">
                                        Rekapitulasi jumlah dosen aktif berdasarkan Program Studi (Homebase)
                                    </p>
                                </div>
                            </div>

                            <!-- Right: Dropdown & Toggle Action Buttons -->
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <!-- Dropdown Filter / Rincian Per Prodi -->
                                <div class="dropdown" style="position: relative; z-index: 1050;">
                                    <button class="btn btn-sm btn-outline-success dropdown-toggle mb-0 d-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-none font-weight-bold" type="button" id="dropdownProdiDosen" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem;">
                                        <i class="fas fa-filter text-success"></i>
                                        <span id="selectedProdiLabel">Pilih / Rincian Prodi</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-2 mt-2" aria-labelledby="dropdownProdiDosen" style="min-width: 300px; max-height: 380px; overflow-y: auto; border-radius: 14px; z-index: 1060; box-shadow: 0 10px 30px rgba(0,0,0,0.18) !important;">
                                        <li>
                                            <h6 class="dropdown-header text-uppercase text-xxs font-weight-bolder text-secondary px-3 py-1 mb-1">
                                                <i class="fas fa-layer-group me-1 text-success"></i> Distribusi Per Prodi
                                            </h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex justify-content-between align-items-center px-3 py-2 font-weight-bold text-xs" href="javascript:;" onclick="filterTableByProdi('', 'Semua Program Studi')">
                                                <span><i class="fas fa-th-large me-2 text-secondary"></i> Semua Program Studi</span>
                                                <span class="badge bg-success-light text-success font-weight-bolder px-2 py-1 rounded-pill" style="background-color: #E8F5E9;">{{ $totalDosen ?? 0 }} Dosen</span>
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        @if(isset($dosenPerProdi) && count($dosenPerProdi) > 0)
                                            @foreach($dosenPerProdi as $prodi)
                                                @php
                                                    $prodiName = $prodi->homebase ?: 'Tanpa Homebase / Belum Diatur';
                                                    $prodiVal = $prodi->homebase ?: '';
                                                @endphp
                                                <li>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center px-3 py-2 text-xs" href="javascript:;" onclick="filterTableByProdi('{{ addslashes($prodiVal) }}', '{{ addslashes($prodiName) }}')">
                                                        <span class="text-truncate me-2" title="{{ $prodiName }}">
                                                            <i class="fas fa-graduation-cap me-2 text-primary"></i> {{ $prodiName }}
                                                        </span>
                                                        <span class="badge bg-light text-dark font-weight-bold px-2 py-1 rounded-pill border">{{ $prodi->total }} Dosen</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li>
                                                <span class="dropdown-item text-muted text-xs px-3 py-2">Belum ada data dosen</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                <!-- Toggle Grid Breakdown Accordion -->
                                <button class="btn btn-sm btn-light border mb-0 d-flex align-items-center gap-1.5 px-3 py-2 rounded-3 text-dark font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDosenGrid" aria-expanded="false" aria-controls="collapseDosenGrid" id="btnToggleProdiGrid" style="font-size: 0.8rem;">
                                    <i class="fas fa-chart-pie text-success me-1"></i>
                                    <span id="textToggleGrid">Lihat Grid Prodi</span>
                                    <i class="fas fa-chevron-down ms-1 transition-icon" id="iconChevronGrid" style="transition: transform 0.3s ease; font-size: 0.75rem;"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Active Filter Indicator Banner -->
                        <div id="activeFilterAlert" class="alert alert-light border d-none align-items-center justify-content-between mt-3 mb-0 py-2 px-3 rounded-3" style="background-color: #f0fdf4; border-color: #bbf7d0 !important;">
                            <div class="d-flex align-items-center text-xs text-success font-weight-bold">
                                <i class="fas fa-filter me-2"></i>
                                <span>Menampilkan data prodi: <span id="activeFilterName" class="text-dark font-weight-bolder"></span></span>
                            </div>
                            <button type="button" class="btn btn-link text-danger p-0 m-0 text-xs font-weight-bold text-decoration-none" onclick="filterTableByProdi('', '')">
                                <i class="fas fa-times-circle me-1"></i> Reset Filter
                            </button>
                        </div>

                        <!-- Collapsible Grid Per Prodi -->
                        <div class="collapse mt-3 pt-3 border-top" id="collapseDosenGrid">
                            <div class="row g-2 g-md-3">
                                @if(isset($dosenPerProdi) && count($dosenPerProdi) > 0)
                                    @foreach($dosenPerProdi as $prodi)
                                        @php
                                            $prodiName = $prodi->homebase ?: 'Tanpa Homebase / Belum Diatur';
                                            $prodiVal = $prodi->homebase ?: '';
                                            $percent = ($totalDosen && $totalDosen > 0) ? round(($prodi->total / $totalDosen) * 100) : 0;
                                        @endphp
                                        <div class="col-xl-3 col-lg-4 col-sm-6">
                                            <div class="p-3 rounded-3 border bg-white h-100 hover-shadow-sm transition-all cursor-pointer prodi-card-item" onclick="filterTableByProdi('{{ addslashes($prodiVal) }}', '{{ addslashes($prodiName) }}')" style="transition: all 0.2s ease; cursor: pointer;">
                                                <div class="d-flex align-items-start justify-content-between mb-2">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="p-2 rounded-2" style="background-color: #E8F5E9; color: #046B26;">
                                                            <i class="fas fa-graduation-cap"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="text-xs font-weight-bold mb-0 text-dark text-truncate" style="max-width: 150px;" title="{{ $prodiName }}">{{ $prodiName }}</h6>
                                                            <span class="text-xxs text-muted">{{ $percent }}% dari total dosen</span>
                                                        </div>
                                                    </div>
                                                    <span class="badge bg-success rounded-pill font-weight-bolder text-xs px-2.5 py-1">
                                                        {{ $prodi->total }}
                                                    </span>
                                                </div>
                                                <div class="progress" style="height: 5px; border-radius: 4px; background-color: #e9ecef;">
                                                    <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-center py-3 text-muted text-xs">
                                        Belum ada data distribusi dosen per program studi.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow-sm border-radius-lg">
                    @if (auth()->check() && !auth()->user()->isOnlyDosen())
                        <div class="card-header p-3 py-3 bg-transparent border-bottom d-flex align-items-center gap-2">
                            <a href="{{ route('user.create') }}" class="btn btn-primary text-white text-uppercase mb-0">
                                <i class="fas fa-user-plus me-1"></i> Tambah Pengguna
                            </a>
                            <a href="javascript:;" class="btn btn-success text-white text-uppercase mb-0" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fas fa-file-excel me-1"></i> Import Excel
                            </a>
                        </div>
                    @endif

                    <div class="card-body p-3">
                        {{ $dataTable->table([
                            'class' => 'table table-hover align-items-center mb-0 w-100',
                            'style' => 'width: 100%;'
                        ]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Pengguna -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header text-white" style="background: linear-gradient(310deg, #046B26 0%, #0db846 100%); border-bottom: none; padding: 1rem 1.25rem;">
                    <h6 class="modal-title text-white font-weight-bold d-flex align-items-center mb-0" id="importModalLabel" style="font-size: 0.95rem;">
                        <i class="fas fa-file-excel me-2" style="font-size: 1.15rem;"></i>
                        Import Pengguna Excel
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-3 p-md-4">
                        <!-- Blue Info Box -->
                        <div class="p-3 mb-3" style="background-color: #e1f5fe; border: 1px solid #b3e5fc; border-radius: 10px;">
                            <p class="mb-2 text-xs" style="line-height: 1.5; color: #01579b;">
                                Format header: <strong>name, email, password, roles, fakultas, homebase</strong>.
                            </p>
                            <a href="{{ route('user.template') }}" class="d-inline-flex align-items-center text-xs font-weight-bold text-decoration-none" style="color: #0288d1;">
                                <i class="fas fa-cloud-arrow-down me-1" style="font-size: 14px;"></i> Download Template
                            </a>
                        </div>

                        <div class="mb-2">
                            <label for="file" class="form-label font-weight-bold text-xs text-dark mb-1">Pilih File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        </div>
                    </div>
                    <div class="modal-footer p-3 bg-light border-0 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light btn-sm mb-0 px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm mb-0 px-4" style="background: #046B26; border: none;">
                            <i class="fas fa-file-import me-1"></i> Import Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @if (app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script>
        function filterTableByProdi(prodiValue, prodiLabel) {
            var table = window.LaravelDataTables ? window.LaravelDataTables['user-table'] : $('#user-table').DataTable();
            if (table) {
                table.search(prodiValue).draw();
            }

            if (prodiValue) {
                $('#selectedProdiLabel').html('<i class="fas fa-check-circle text-success me-1"></i> ' + (prodiLabel || prodiValue));
                $('#activeFilterName').text(prodiLabel || prodiValue);
                $('#activeFilterAlert').removeClass('d-none').addClass('d-flex');
            } else {
                $('#selectedProdiLabel').text('Pilih / Rincian Prodi');
                $('#activeFilterAlert').removeClass('d-flex').addClass('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var collapseElement = document.getElementById('collapseDosenGrid');
            var textToggle = document.getElementById('textToggleGrid');
            var iconChevron = document.getElementById('iconChevronGrid');

            if (collapseElement) {
                collapseElement.addEventListener('show.bs.collapse', function () {
                    if (textToggle) textToggle.textContent = 'Tutup Grid Prodi';
                    if (iconChevron) iconChevron.style.transform = 'rotate(180deg)';
                });

                collapseElement.addEventListener('hide.bs.collapse', function () {
                    if (textToggle) textToggle.textContent = 'Lihat Grid Prodi';
                    if (iconChevron) iconChevron.style.transform = 'rotate(0deg)';
                });
            }
        });
    </script>
@endpush
