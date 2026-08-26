@extends('layouts.dashboard.template')

@section('title', 'Ubah Password Pengguna')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Ubah Password</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('user.updatePassword', $users->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="new_password" class="form-label font-weight-bold text-xs text-dark">Password Baru</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Minimal 8 karakter" required>
                                @error('new_password')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label font-weight-bold text-xs text-dark">Konfirmasi Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Ulangi password baru" required>
                                @error('confirm_password')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-2 pt-2">
                                <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-key me-1"></i> Ubah Password
                                </button>
                                <a href="{{ route('user.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
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
