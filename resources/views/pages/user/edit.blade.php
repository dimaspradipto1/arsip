@extends('layouts.dashboard.template')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Pengguna</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Edit Pengguna</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" placeholder="Type here...">
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
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

                                        <!-- Roles / Status as checkboxes -->
                                        <div class="col-md-6 mb-md-0 my-4">
                                            <label class="d-block">Role Akses</label>

                                            <!-- Hidden input to ensure value 0 is sent when checkbox is unchecked -->
                                            <input type="hidden" name="isAdmin" value="0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="isAdmin"
                                                    id="isAdmin" value="1" {{ $user->isAdmin ? 'checked' : '' }}>
                                                <label class="form-check-label" for="isAdmin">Admin</label>
                                            </div>

                                            <!-- Hidden input to ensure value 0 is sent when checkbox is unchecked -->
                                            <input type="hidden" name="isDosen" value="0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="isDosen"
                                                    id="isDosen" value="1" {{ $user->isDosen ? 'checked' : '' }}>
                                                <label class="form-check-label" for="isDosen">Dosen</label>
                                            </div>
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
