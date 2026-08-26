@extends('layouts.dashboard.template')

@section('title', 'Edit SK Kepanitiaan')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Edit SK Kepanitiaan</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('skkepanitiaan.update', $skkepanitiaan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="tahunakademik_id" class="form-label font-weight-bold text-xs text-dark">Tahun Akademik</label>
                                <select name="tahunakademik_id" id="tahunakademik_id" class="form-control select2" data-placeholder="-- Pilih Tahun Akademik --">
                                    <option value="">-- Pilih Tahun Akademik --</option>
                                    @foreach ($tahunakademik as $item)
                                        <option value="{{ $item->id }}" {{ old('tahunakademik_id', $skkepanitiaan->tahunakademik_id) == $item->id ? 'selected' : '' }}>{{ $item->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                                @error('tahunakademik_id')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kategorysk_id" class="form-label font-weight-bold text-xs text-dark">Kategori SK</label>
                                <select name="kategorysk_id" id="kategorysk_id" class="form-control select2" data-placeholder="-- Pilih Kategori SK --">
                                    <option value="">-- Pilih Kategori SK --</option>
                                    @foreach ($kategorysk as $item)
                                        <option value="{{ $item->id }}" {{ old('kategorysk_id', $skkepanitiaan->kategorysk_id) == $item->id ? 'selected' : '' }}>{{ $item->kategory_sk }}</option>
                                    @endforeach
                                </select>
                                @error('kategorysk_id')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nomor_sk" class="form-label font-weight-bold text-xs text-dark">Nomor SK</label>
                                <input type="text" name="nomor_sk" id="nomor_sk" value="{{ old('nomor_sk', $skkepanitiaan->nomor_sk) }}" class="form-control" placeholder="Masukkan nomor SK">
                                @error('nomor_sk')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dokumen" class="form-label font-weight-bold text-xs text-dark">Dokumen SK</label>
                                <textarea name="dokumen" id="dokumen" rows="3" class="form-control" placeholder="Masukkan link Google Drive dokumen SK (contoh: https://drive.google.com/file/d/...)">{{ old('dokumen', $skkepanitiaan->dokumen) }}</textarea>
                                @error('dokumen')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-2 pt-2">
                                <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <a href="{{ route('skkepanitiaan.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
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