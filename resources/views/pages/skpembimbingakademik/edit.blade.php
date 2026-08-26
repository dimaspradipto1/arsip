@extends('layouts.dashboard.template')

@section('title', 'Edit SK Pembimbing Akademik')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Edit SK Pembimbing Akademik</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('skpembimbingakademik.update', $skpembimbingakademik) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @php
                                $listFakultas = [
                                    'FAKULTAS EKONOMI DAN BISNIS (FEB)',
                                    'FAKULTAS SAINS DAN TEKNOLOGI (FST)',
                                    'FAKULTAS ILMU KESEHATAN (FIKes)',
                                ];

                                $listProdi = [
                                    'S2-MAGISTER MANAJEMEN',
                                    'S2-KESEHATAN MASYARAKAT',
                                    'S1-AKUNTANSI',
                                    'S1-MANAJEMEN',
                                    'S1-TEKNIK INDUSTRI',
                                    'S1-TEKNIK INFORMATIKA',
                                    'S1-TEKNIK LOGISTIK',
                                    'S1-SISTEM INFORMASI',
                                    'S1-TEKNIK PERKAPALAN',
                                    'S1-KESEHATAN DAN KESELAMATAN KERJA',
                                    'S1-KESEHATAN LINGKUNGAN',
                                ];
                            @endphp

                            <div class="mb-3">
                                <label for="tahunakademik_id" class="form-label font-weight-bold text-xs text-dark">Tahun Akademik <span class="text-danger">*</span></label>
                                <select name="tahunakademik_id" id="tahunakademik_id" class="form-control select2" data-placeholder="-- Pilih Tahun Akademik --" required>
                                    <option value="">-- Pilih Tahun Akademik --</option>
                                    @foreach ($tahunakademik as $item)
                                        <option value="{{ $item->id }}" {{ old('tahunakademik_id', $skpembimbingakademik->tahunakademik_id) == $item->id ? 'selected' : '' }}>{{ $item->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                                @error('tahunakademik_id')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="user_id" class="form-label font-weight-bold text-xs text-dark">Nama Dosen <span class="text-danger">*</span></label>
                                <select name="user_id" id="user_id" class="form-control select2" data-placeholder="-- Pilih Dosen --" required>
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" data-homebase="{{ $user->homebase ?? '' }}" data-fakultas="{{ $user->fakultas ?? '' }}" {{ old('user_id', $skpembimbingakademik->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} {{ $user->homebase ? '(' . $user->homebase . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nomor_sk" class="form-label font-weight-bold text-xs text-dark">Nomor SK <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_sk" id="nomor_sk" value="{{ old('nomor_sk', $skpembimbingakademik->nomor_sk) }}" class="form-control" placeholder="Masukkan nomor SK" required>
                                @error('nomor_sk')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="fakultas" class="form-label font-weight-bold text-xs text-dark">Fakultas</label>
                                <select name="fakultas" id="fakultas" class="form-control select2" data-placeholder="-- Pilih Fakultas --">
                                    <option value="">-- Pilih Fakultas --</option>
                                    @foreach ($listFakultas as $fak)
                                        <option value="{{ $fak }}" {{ old('fakultas', $skpembimbingakademik->fakultas) == $fak ? 'selected' : '' }}>{{ $fak }}</option>
                                    @endforeach
                                </select>
                                @error('fakultas')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="prodi" class="form-label font-weight-bold text-xs text-dark">Program Studi (Prodi)</label>
                                <select name="prodi" id="prodi" class="form-control select2" data-placeholder="-- Pilih Program Studi --">
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach ($listProdi as $prd)
                                        <option value="{{ $prd }}" {{ old('prodi', $skpembimbingakademik->prodi) == $prd ? 'selected' : '' }}>{{ $prd }}</option>
                                    @endforeach
                                </select>
                                @error('prodi')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dokumen" class="form-label font-weight-bold text-xs text-dark">Dokumen SK <span class="text-danger">*</span></label>
                                <textarea name="dokumen" id="dokumen" rows="3" class="form-control" placeholder="Masukkan link Google Drive dokumen SK (contoh: https://drive.google.com/file/d/...)" required>{{ old('dokumen', $skpembimbingakademik->dokumen) }}</textarea>
                                @error('dokumen')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-2 pt-2">
                                <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <a href="{{ route('skpembimbingakademik.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
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
