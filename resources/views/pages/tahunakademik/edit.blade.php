@extends('layouts.dashboard.template')

@section('title', 'Edit Tahun Akademik')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-6">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Edit Tahun Akademik</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('tahunakademik.update', $tahunakademik->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="tahun_akademik" class="form-label font-weight-bold text-xs text-dark">Tahun Akademik</label>
                                <input type="text" name="tahun_akademik" id="tahun_akademik" value="{{ old('tahun_akademik', $tahunakademik->tahun_akademik) }}" class="form-control" required>
                                @error('tahun_akademik')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-2 pt-2">
                                <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <a href="{{ route('tahunakademik.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
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