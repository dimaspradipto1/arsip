@extends('layouts.dashboard.template')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom d-flex align-items-center gap-2">
                        <a href="{{ route('user.create') }}" class="btn btn-primary text-white text-uppercase mb-0">
                            <i class="fas fa-plus me-1"></i> Tambah Pengguna
                        </a>
                        <!-- Button to trigger modal -->
                        <a href="javascript:;" class="btn btn-success text-white text-uppercase mb-0" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-excel me-1"></i> Import
                        </a>
                    </div>

                    <!-- Modal Import -->
                    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow" style="border-radius: 14px;">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="importModalLabel">Import Pengguna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label for="file" class="form-label font-weight-bold text-xs text-dark">Pilih File Excel (.xlsx, .xls)</label>
                                            <input type="file" class="form-control" name="file" id="file" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer p-3 bg-light border-0">
                                        <button type="button" class="btn btn-secondary btn-sm mb-0" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary btn-sm mb-0">Import Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <div class="table-responsive">
                            {{ $dataTable->table([
                                'class' => 'table table-hover align-items-center mb-0 w-100',
                                'style' => 'width: 100%;'
                            ]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- {!! str_replace('http:', 'https:', $dataTable->scripts()) !!} --}}
    {!! $dataTable->scripts() !!}
@endpush
