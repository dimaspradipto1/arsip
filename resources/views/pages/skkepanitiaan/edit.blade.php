@extends('layouts.dashboard.template')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit SK Panitia</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Edit SK Panitia</h6>
            </nav>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-12 mb-lg-0 mb-4">
                        <div class="card mt-4">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center">
                                        <h6 class="mb-0">Form Edit SK Panitia</h6>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <form action="{{ route('skkepanitiaan.update', $skkepanitiaan) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="col-md-8 mb-md-0 mb-4">
                                            <label for="tahun_akademik">Tahun Akademik</label>
                                            <select name="tahunakademik_id" id="tahunakademik_id" class="form-control">
                                                <option value="">-- Pilih Tahun Akademik --</option>
                                                @foreach ($tahunakademik as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id == $skkepanitiaan->tahunakademik_id ? 'selected' : '' }}>{{ $item->tahun_akademik }}</option>
                                                @endforeach
                                            </select>
                                            @error('tahunakademik_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-8 mb-md-0 mb-4">
                                            <label for="kategorysk_id">Kategory SK</label>
                                            <select name="kategorysk_id" id="kategorysk_id" class="form-control">
                                                <option value="">-- Pilih Kategory SK --</option>
                                                @foreach ($kategorysk as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id == $skkepanitiaan->kategorysk_id ? 'selected' : '' }}>{{ $item->kategory_sk }}</option>
                                                @endforeach
                                            </select>
                                            @error('kategorysk_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-8 mb-md-0 mb-4">
                                            <label for="nomor_sk">Nomor SK</label>
                                            <input type="text" name="nomor_sk" value="{{ old('nomor_sk', $skkepanitiaan->nomor_sk) }}" class="form-control">
                                            @error('nomor_sk')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-8 mb-md-0 mb-4">
                                            <label for="dokumen">Dokumen SK</label>
                                           <textarea name="dokumen" id="dokumen" class="form-control">{{ old('dokumen', $skkepanitiaan->dokumen) }}</textarea>
                                            @error('dokumen')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 text-start py-3">
                                            <button type="submit"
                                                class="btn btn-dark text-white text-uppercase">Simpan</button>
                                            <a href="{{ route('skkepanitiaan.index') }}"
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