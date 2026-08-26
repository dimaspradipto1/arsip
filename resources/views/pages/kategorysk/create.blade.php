@extends('layouts.dashboard.template')

@section('title', 'Tambah Kategori SK')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-6">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Tambah Kategori SK</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('kategorysk.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="kategory_sk" class="form-label font-weight-bold text-xs text-dark">Nama Kategori SK</label>
                                <input type="text" name="kategory_sk" id="kategory_sk" value="{{ old('kategory_sk') }}" class="form-control" placeholder="Contoh: SK Semester Antara" required>
                                @error('kategory_sk')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-2 pt-2">
                                <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('kategorysk.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection