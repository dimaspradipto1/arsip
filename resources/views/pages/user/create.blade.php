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
                                    <input type="text" name="fakultas" id="fakultas" class="form-control" value="{{ old('fakultas') }}" placeholder="Fakultas">
                                    @error('fakultas')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="homebase" class="form-label font-weight-bold text-xs text-dark">Homebase / Program Studi</label>
                                    <input type="text" name="homebase" id="homebase" class="form-control" value="{{ old('homebase') }}" placeholder="Program Studi">
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
