@extends('layouts.dashboard.template')

@section('title', 'Tahun Akademik')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <a href="{{ route('tahunakademik.create') }}" class="btn btn-primary text-white text-uppercase"><i
                                class="fa-solid fa-plus"></i> Tambah Tahun Akademik</a>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            {{ $dataTable->table([
                                'style' => 'width:100%; overflow-x: auto',
                            ]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- {!! str_replace('http:', 'https:', $dataTable->scripts()) !!} --}}
    {!! $dataTable->scripts() !!}
@endpush
