@extends('layouts.dashboard.template')

@section('title', 'Ubah Password Pengguna')

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
                                        <h6 class="mb-0">Form Ubah Password</h6>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <form action="{{ route('user.updatePassword', $users->id) }}" method="POST">
                                        @csrf
                                        @method('POST')

                                        <div class="col-md-6 mb-md-0 mb-4">
                                            <label for="new_password">Password Baru</label>
                                            <input type="password" name="new_password" class="form-control" required>
                                        </div>

                                        <div class="col-md-6 mb-md-0 mb-4">
                                            <label for="confirm_password">Konfirmasi Password</label>
                                            <input type="password" name="confirm_password" class="form-control" required>
                                        </div>

                                        <div class="col-12 text-start py-3">
                                            <button type="submit"
                                                class="btn btn-dark text-white text-uppercase">ubah</button>
                                            <a href="{{ route('user.index') }}"
                                                class="btn btn-danger text-white text-uppercase">kembali</a>
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
