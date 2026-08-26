@extends('layouts.dashboard.template')

@section('title', 'SK Pembimbing Akademik')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom d-flex align-items-center justify-content-between">
                        <a href="{{ route('skpembimbingakademik.create') }}" class="btn btn-primary text-white text-uppercase mb-0">
                            <i class="fas fa-plus me-1"></i> Tambah SK Pembimbing Akademik
                        </a>
                    </div>

                    <div class="card-body p-3">
                        <div class="table-responsive">
                            {{ $dataTable->table([
                                'class' => 'table table-hover align-items-center mb-0 w-100',
                                'style' => 'width: 100%;',
                            ]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @if (app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
