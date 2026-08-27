@extends('layouts.dashboard.template')

@section('title', 'Kategori SK')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow-sm border-radius-lg">
                    @if (auth()->check() && !auth()->user()->isOnlyDosen())
                        <div class="card-header p-3 py-3 bg-transparent border-bottom d-flex align-items-center justify-content-between">
                            <a href="{{ route('kategorysk.create') }}" class="btn btn-primary text-white text-uppercase mb-0">
                                <i class="fas fa-plus me-1"></i> Tambah Kategori SK
                            </a>
                        </div>
                    @endif

                    <div class="card-body p-3">
                        {{ $dataTable->table([
                            'class' => 'table table-hover align-items-center mb-0 w-100',
                            'style' => 'width: 100%;'
                        ]) }}
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
