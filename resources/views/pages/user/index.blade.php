@extends('layouts.dashboard.template')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <a href="{{ route('user.create') }}" class="btn btn-primary text-white text-uppercase"><i
                                class="fa-solid fa-plus"></i> Tambah Pengguna</a>
                        <!-- Button to trigger modal -->
                        <a href="javascript:;" class="btn btn-success text-white text-uppercase" data-bs-toggle="modal"
                            data-bs-target="#importModal"><i class="fa-solid fa-file-excel"></i> Import</a>
                    </div>

                    <!-- Modal Import -->
                    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">Import Pengguna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="excel_file" class="form-label">Pilih File Excel</label>
                                            <input type="file" class="form-control" name="excel_file" id="excel_file"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Import -->

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            {{ $dataTable->table([
                                'style' => 'width:100%; overflow-x: auto',
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
