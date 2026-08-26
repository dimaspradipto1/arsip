@extends('layouts.dashboard.template')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Tambah Pengguna</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="name" class="form-label font-weight-bold text-xs text-dark">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama" required>
                                    @error('name')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label font-weight-bold text-xs text-dark">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="nama@uis.ac.id" required>
                                    @error('email')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="fakultas" class="form-label font-weight-bold text-xs text-dark">Fakultas</label>
                                    <select name="fakultas" id="fakultas" class="form-control select2" data-placeholder="-- Pilih Fakultas --">
                                        <option value="">-- Pilih Fakultas --</option>
                                        <option value="FAKULTAS EKONOMI DAN BISNIS (FEB)" {{ old('fakultas') == 'FAKULTAS EKONOMI DAN BISNIS (FEB)' ? 'selected' : '' }}>FAKULTAS EKONOMI DAN BISNIS (FEB)</option>
                                        <option value="FAKULTAS SAINS DAN TEKNOLOGI (FST)" {{ old('fakultas') == 'FAKULTAS SAINS DAN TEKNOLOGI (FST)' ? 'selected' : '' }}>FAKULTAS SAINS DAN TEKNOLOGI (FST)</option>
                                        <option value="FAKULTAS ILMU KESEHATAN (FIKes)" {{ old('fakultas') == 'FAKULTAS ILMU KESEHATAN (FIKes)' ? 'selected' : '' }}>FAKULTAS ILMU KESEHATAN (FIKes)</option>
                                    </select>
                                    @error('fakultas')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="homebase" class="form-label font-weight-bold text-xs text-dark">Homebase / Program Studi</label>
                                    <select name="homebase" id="homebase" class="form-control select2" data-placeholder="-- Pilih Program Studi --">
                                        <option value="">-- Pilih Program Studi --</option>
                                        <option value="S2-MAGISTER MANAJEMEN" {{ old('homebase') == 'S2-MAGISTER MANAJEMEN' ? 'selected' : '' }}>S2-MAGISTER MANAJEMEN</option>
                                        <option value="S2-KESEHATAN MASYARAKAT" {{ old('homebase') == 'S2-KESEHATAN MASYARAKAT' ? 'selected' : '' }}>S2-KESEHATAN MASYARAKAT</option>
                                        <option value="S1-AKUNTANSI" {{ old('homebase') == 'S1-AKUNTANSI' ? 'selected' : '' }}>S1-AKUNTANSI</option>
                                        <option value="S1-MANAJEMEN" {{ old('homebase') == 'S1-MANAJEMEN' ? 'selected' : '' }}>S1-MANAJEMEN</option>
                                        <option value="S1-TEKNIK INDUSTRI" {{ old('homebase') == 'S1-TEKNIK INDUSTRI' ? 'selected' : '' }}>S1-TEKNIK INDUSTRI</option>
                                        <option value="S1-TEKNIK INFORMATIKA" {{ old('homebase') == 'S1-TEKNIK INFORMATIKA' ? 'selected' : '' }}>S1-TEKNIK INFORMATIKA</option>
                                        <option value="S1-TEKNIK LOGISTIK" {{ old('homebase') == 'S1-TEKNIK LOGISTIK' ? 'selected' : '' }}>S1-TEKNIK LOGISTIK</option>
                                        <option value="S1-SISTEM INFORMASI" {{ old('homebase') == 'S1-SISTEM INFORMASI' ? 'selected' : '' }}>S1-SISTEM INFORMASI</option>
                                        <option value="S1-TEKNIK PERKAPALAN" {{ old('homebase') == 'S1-TEKNIK PERKAPALAN' ? 'selected' : '' }}>S1-TEKNIK PERKAPALAN</option>
                                        <option value="S1-KESEHATAN DAN KESELAMATAN KERJA" {{ old('homebase') == 'S1-KESEHATAN DAN KESELAMATAN KERJA' ? 'selected' : '' }}>S1-KESEHATAN DAN KESELAMATAN KERJA</option>
                                        <option value="S1-KESEHATAN LINGKUNGAN" {{ old('homebase') == 'S1-KESEHATAN LINGKUNGAN' ? 'selected' : '' }}>S1-KESEHATAN LINGKUNGAN</option>
                                    </select>
                                    @error('homebase')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="myInput" class="form-label font-weight-bold text-xs text-dark">Password</label>
                                    <input type="password" name="password" class="form-control" id="myInput" placeholder="Minimal 8 karakter" required>
                                    <div class="form-check form-check-info text-start mt-2">
                                        <input class="form-check-input" type="checkbox" id="flexCheckDefault" onclick="myFunction()">
                                        <label class="form-check-label text-xs text-secondary" for="flexCheckDefault">
                                            Tampilkan Password
                                        </label>
                                    </div>
                                    @error('password')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="roles" class="form-label font-weight-bold text-xs text-dark">Role / Hak Akses</label>
                                    <select name="roles" id="roles" class="form-control select2" data-placeholder="-- Pilih Role --" required>
                                        <option value="" disabled selected>-- Pilih Role --</option>
                                        <option value="admin" {{ old('roles') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="tatausaha" {{ old('roles') == 'tatausaha' ? 'selected' : '' }}>Tata Usaha</option>
                                        <option value="dosen" {{ old('roles') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                        <option value="dekan" {{ old('roles') == 'dekan' ? 'selected' : '' }}>Dekan</option>
                                        <option value="wakilDekan1" {{ old('roles') == 'wakilDekan1' ? 'selected' : '' }}>Wakil Dekan 1</option>
                                        <option value="wakilDekan2" {{ old('roles') == 'wakilDekan2' ? 'selected' : '' }}>Wakil Dekan 2</option>
                                        <option value="kaprodi" {{ old('roles') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                                        <option value="sekprodi" {{ old('roles') == 'sekprodi' ? 'selected' : '' }}>Sekprodi</option>
                                    </select>
                                    @error('roles')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 text-start pt-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                            <i class="fas fa-save me-1"></i> Simpan
                                        </button>
                                        <a href="{{ route('user.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
                                            <i class="fas fa-arrow-left me-1"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endpush
