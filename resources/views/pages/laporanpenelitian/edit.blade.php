@extends('layouts.dashboard.template')

@section('title', 'Edit Laporan Penelitian')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Edit Laporan Penelitian</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('laporanpenelitian.update', $laporanpenelitian->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="tahun_kegiatan" class="form-label font-weight-bold text-xs text-dark">Tahun Kegiatan <span class="text-danger">*</span></label>
                                    <input type="number" name="tahun_kegiatan" id="tahun_kegiatan" value="{{ old('tahun_kegiatan', $laporanpenelitian->tahun_kegiatan) }}" class="form-control" placeholder="Contoh: 2024" required>
                                    @error('tahun_kegiatan')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="user_id" class="form-label font-weight-bold text-xs text-dark">Nama Dosen <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control select2" data-placeholder="-- Pilih Dosen --" required>
                                        <option value="">-- Pilih Dosen --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $laporanpenelitian->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} {{ $user->homebase ? '(' . $user->homebase . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="judul_penelitian" class="form-label font-weight-bold text-xs text-dark">Judul Penelitian <span class="text-danger">*</span></label>
                                <textarea name="judul_penelitian" id="judul_penelitian" rows="3" class="form-control" placeholder="Masukkan judul lengkap laporan penelitian" required>{{ old('judul_penelitian', $laporanpenelitian->judul_penelitian) }}</textarea>
                                @error('judul_penelitian')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dokumen" class="form-label font-weight-bold text-xs text-dark">Dokumen <span class="text-danger">*</span></label>
                                <textarea name="dokumen" id="dokumen" rows="3" class="form-control" placeholder="Masukkan link Google Drive dokumen laporan penelitian (contoh: https://drive.google.com/file/d/...)" required>{{ old('dokumen', $laporanpenelitian->dokumen) }}</textarea>
                                @error('dokumen')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-2 pt-2">
                                <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <a href="{{ route('laporanpenelitian.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
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
