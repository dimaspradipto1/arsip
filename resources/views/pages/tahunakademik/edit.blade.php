@extends('layouts.dashboard.template')

@section('title', 'Edit Tahun Akademik')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-12 mb-lg-0 mb-4">
                        <div class="card mt-4">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center">
                                        <h6 class="mb-0">Form Edit Tahun Akademik</h6>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <form action="{{ route('tahunakademik.update', $tahunakademik->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="col-md-8 mb-md-0 mb-4">
                                            <label for="tahun_akademik">Tahun Akademik</label>
                                            <input type="text" name="tahun_akademik" value="{{ old('tahun_akademik', $tahunakademik->tahun_akademik) }}" class="form-control">
                                            @error('tahun_akademik')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 text-start py-3">
                                            <button type="submit"
                                                class="btn btn-dark text-white text-uppercase">Simpan</button>
                                            <a href="{{ route('tahunakademik.index') }}"
                                                class="btn btn-danger text-white text-uppercase">Kembali</a>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection