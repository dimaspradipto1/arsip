@extends('layouts.dashboard.template')

@section('title', 'Edit SK Penguji Seminar Proposal')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Edit SK Penguji Seminar Proposal</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('skpengujisempro.update', $skpengujisempro) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="tahunakademik_id" class="form-label font-weight-bold text-xs text-dark">Tahun Akademik <span class="text-danger">*</span></label>
                                <select name="tahunakademik_id" id="tahunakademik_id" class="form-control select2" data-placeholder="-- Pilih Tahun Akademik --" required>
                                    <option value="">-- Pilih Tahun Akademik --</option>
                                    @foreach ($tahunakademik as $item)
                                        <option value="{{ $item->id }}" {{ old('tahunakademik_id', $skpengujisempro->tahunakademik_id) == $item->id ? 'selected' : '' }}>{{ $item->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                                @error('tahunakademik_id')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            @php
                                $selectedUserIds = old('user_ids', $skpengujisempro->users->pluck('id')->toArray());
                            @endphp

                            <div class="mb-3">
                                <label for="user_ids" class="form-label font-weight-bold text-xs text-dark mb-0">Nama Dosen Penguji <span class="text-danger">*</span></label>
                                <span class="d-block text-xxs text-secondary mb-2">Ketik & cari nama dosen, klik untuk memilih (bisa pilih lebih dari satu dosen).</span>
                                <select name="user_ids[]" id="user_ids" class="form-control select2" multiple="multiple" data-placeholder="Ketik & pilih dosen penguji..." required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ in_array($user->id, (array) $selectedUserIds) ? 'selected' : '' }}>
                                            {{ $user->name }} {{ $user->homebase ? '(' . $user->homebase . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_ids')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nomor_sk" class="form-label font-weight-bold text-xs text-dark">Nomor SK <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_sk" id="nomor_sk" value="{{ old('nomor_sk', $skpengujisempro->nomor_sk) }}" class="form-control" placeholder="Masukkan nomor SK" required>
                                @error('nomor_sk')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_mahasiswa" class="form-label font-weight-bold text-xs text-dark">Nama Mahasiswa <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" value="{{ old('nama_mahasiswa', $skpengujisempro->nama_mahasiswa) }}" class="form-control" placeholder="Masukkan nama mahasiswa" required>
                                    @error('nama_mahasiswa')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="npm" class="form-label font-weight-bold text-xs text-dark">NPM <span class="text-danger">*</span></label>
                                    <input type="text" name="npm" id="npm" value="{{ old('npm', $skpengujisempro->npm) }}" class="form-control" placeholder="Masukkan NPM mahasiswa" required>
                                    @error('npm')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_sk" class="form-label font-weight-bold text-xs text-dark">Tanggal SK <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_sk" id="tanggal_sk" value="{{ old('tanggal_sk', $skpengujisempro->tanggal_sk ? \Carbon\Carbon::parse($skpengujisempro->tanggal_sk)->format('Y-m-d') : '') }}" class="form-control" required>
                                @error('tanggal_sk')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dokumen" class="form-label font-weight-bold text-xs text-dark">Dokumen SK <span class="text-danger">*</span></label>
                                <textarea name="dokumen" id="dokumen" rows="3" class="form-control" placeholder="Masukkan link Google Drive dokumen SK (contoh: https://drive.google.com/file/d/...)" required>{{ old('dokumen', $skpengujisempro->dokumen) }}</textarea>
                                @error('dokumen')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-2 pt-2">
                                <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <a href="{{ route('skpengujisempro.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
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
