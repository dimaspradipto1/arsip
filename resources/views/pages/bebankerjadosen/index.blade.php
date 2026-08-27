@extends('layouts.dashboard.template')

@section('title', 'Data LPJ Beban Kerja Dosen')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow-sm border-radius-lg">
                    @if (auth()->check() && !auth()->user()->isOnlyDosen())
                        <div class="card-header p-3 py-3 bg-transparent border-bottom d-flex align-items-center gap-2">
                            <a href="{{ route('bebankerjadosen.create') }}" class="btn btn-primary text-white text-uppercase mb-0">
                                <i class="fas fa-plus me-1"></i> Tambah Beban Kerja Dosen
                            </a>
                            <a href="javascript:;" class="btn btn-success text-white text-uppercase mb-0" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fas fa-file-excel me-1"></i> Import Excel
                            </a>
                        </div>
                    @endif

                    <div class="card-body p-3">
                        {{ $dataTable->table([
                            'class' => 'table table-hover align-items-center mb-0 w-100',
                            'style' => 'width: 100%;',
                        ]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Beban Kerja Dosen -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header text-white" style="background: linear-gradient(310deg, #046B26 0%, #0db846 100%); border-bottom: none; padding: 1rem 1.25rem;">
                    <h6 class="modal-title text-white font-weight-bold d-flex align-items-center mb-0" id="importModalLabel" style="font-size: 0.95rem;">
                        <i class="fas fa-file-excel me-2" style="font-size: 1.15rem;"></i>
                        Import Data LPJ Beban Kerja Dosen Excel
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bebankerjadosen.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-3 p-md-4">
                        <!-- Blue Info Box -->
                        <div class="p-3 mb-3" style="background-color: #e1f5fe; border: 1px solid #b3e5fc; border-radius: 10px;">
                            <p class="mb-2 text-xs" style="line-height: 1.5; color: #01579b;">
                                Format header: <strong>tahun_akademik, ketua_panitia, sekretaris, dokumen</strong>.
                            </p>
                            <a href="{{ route('bebankerjadosen.template') }}" class="d-inline-flex align-items-center text-xs font-weight-bold text-decoration-none" style="color: #0288d1;">
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
                            <i class="fas fa-file-import me-1"></i> Import Data
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
@endpush
