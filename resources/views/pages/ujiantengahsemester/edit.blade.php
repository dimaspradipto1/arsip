@extends('layouts.dashboard.template')

@section('title', 'Edit LPJ Ujian Tengah Semester')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Edit LPJ Ujian Tengah Semester</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('ujiantengahsemester.update', $ujiantengahsemester->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="tahunakademik_id" class="form-label font-weight-bold text-xs text-dark">Tahun Akademik <span class="text-danger">*</span></label>
                                <select name="tahunakademik_id" id="tahunakademik_id" class="form-control select2" data-placeholder="-- Pilih Tahun Akademik --" required>
                                    <option value="">-- Pilih Tahun Akademik --</option>
                                    @foreach ($tahunakademik as $item)
                                        <option value="{{ $item->id }}" {{ old('tahunakademik_id', $ujiantengahsemester->tahunakademik_id) == $item->id ? 'selected' : '' }}>{{ $item->tahun_akademik }}</option>
                                    @endforeach
                                </select>
                                @error('tahunakademik_id')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ketua_id" class="form-label font-weight-bold text-xs text-dark">Ketua <span class="text-danger">*</span></label>
                                    <select name="ketua_id" id="ketua_id" class="form-control select2" data-placeholder="-- Pilih Ketua --" required>
                                        <option value="">-- Pilih Ketua --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('ketua_id', $ujiantengahsemester->ketua_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} {{ $user->homebase ? '(' . $user->homebase . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ketua_id')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sekretaris_id" class="form-label font-weight-bold text-xs text-dark">Sekretaris <span class="text-danger">*</span></label>
                                    <select name="sekretaris_id" id="sekretaris_id" class="form-control select2" data-placeholder="-- Pilih Sekretaris --" required>
                                        <option value="">-- Pilih Sekretaris --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('sekretaris_id', $ujiantengahsemester->sekretaris_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} {{ $user->homebase ? '(' . $user->homebase . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sekretaris_id')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dokumen" class="form-label font-weight-bold text-xs text-dark">Dokumen LPJ <span class="text-danger">*</span></label>
                                <textarea name="dokumen" id="dokumen" rows="3" class="form-control" placeholder="Masukkan link Google Drive dokumen LPJ Ujian Tengah Semester (contoh: https://drive.google.com/file/d/...)" required>{{ old('dokumen', $ujiantengahsemester->dokumen) }}</textarea>
                                @error('dokumen')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-2 pt-2">
                                <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <a href="{{ route('ujiantengahsemester.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
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
