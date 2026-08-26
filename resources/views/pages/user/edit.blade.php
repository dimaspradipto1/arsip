@extends('layouts.dashboard.template')

@section('title', 'Edit Pengguna')

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
                                        <h6 class="mb-0">Form Edit Pengguna</h6>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="col-md-6 mb-md-0 mb-4">
                                            <label for="name">Nama</label>
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                        </div>

                                        <div class="col-md-6 mb-md-0 mb-4">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control"  value="{{ $user->email }}">
                                        </div>

                                        <div class="col-md-6 mb-md-0 mb-4">
                                            <label for="fakultas">Fakultas</label>
                                            <input type="text" name="fakultas" class="form-control" value="{{ $user->fakultas }}">
                                        </div>

                                        <div class="col-md-6 mb-md-0 mb-4">
                                            <label for="homebase">Homebase</label>
                                            <input type="text" name="homebase" class="form-control" value="{{ $user->homebase }}">
                                        </div>

                                        <!-- Role Akses Select -->
                                        <div class="col-md-6 mb-md-0 my-4">
                                            <label for="roles">Role Akses</label>
                                            <select name="roles" id="roles" class="form-control" required>
                                                <option value="admin" {{ old('roles', $user->roles) == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="tatausaha" {{ old('roles', $user->roles) == 'tatausaha' ? 'selected' : '' }}>Tata Usaha</option>
                                                <option value="dosen" {{ old('roles', $user->roles) == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                                <option value="dekan" {{ old('roles', $user->roles) == 'dekan' ? 'selected' : '' }}>Dekan</option>
                                                <option value="wakilDekan1" {{ old('roles', $user->roles) == 'wakilDekan1' ? 'selected' : '' }}>Wakil Dekan 1</option>
                                                <option value="wakilDekan2" {{ old('roles', $user->roles) == 'wakilDekan2' ? 'selected' : '' }}>Wakil Dekan 2</option>
                                                <option value="kaprodi" {{ old('roles', $user->roles) == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                                                <option value="sekprodi" {{ old('roles', $user->roles) == 'sekprodi' ? 'selected' : '' }}>Sekprodi</option>
                                            </select>
                                        </div>

                                        <div class="col-12 text-start py-3">
                                            <button type="submit"
                                                class="btn btn-dark text-white text-uppercase">Update</button>
                                            <a href="{{ route('user.index') }}"
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
