@extends('layouts.dashboard.template')

@php
    $sections = [
        ['id' => 'table-bidang-pendidikan', 'title' => 'Bidang Pendidikan', 'items' => $bidangPendidikan],
        ['id' => 'table-bidang-penelitian', 'title' => 'Bidang Penelitian', 'items' => $bidangPenelitian],
        ['id' => 'table-bidang-pengabdian', 'title' => 'Bidang Pengabdian', 'items' => $bidangPengabdian],
        ['id' => 'table-penunjang', 'title' => 'Penunjang', 'items' => $penunjang],
    ];
@endphp

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <h6 class="mb-3">Data Penelitian / Identitas Karya Ilmiah</h6>

      <div class="card mb-4">
        <div class="card-body pt-3">
          <table id="table-identitas-karya-ilmiah" class="table table-bordered excel-table doc-table align-items-center mb-0" style="width:100%">
            <thead>
              <tr>
                <th style="width:60px">No</th>
                <th style="width:80px">Tahun</th>
                <th>Judul Karya Ilmiah</th>
                <th>Nama Jurnal</th>
                <th>Nomor ISSN</th>
                <th>Volume, Nomor, Tahun</th>
                <th>DOI Artikel</th>
                <th>Alamat Web</th>
                <th>Indexing</th>
                <th>Kategori Publikasi</th>
              </tr>
            </thead>
            <tbody>
              @for ($i = 1; $i <= 22; $i++)
                <tr>
                  <td class="text-center">{{ $i }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              @endfor
            </tbody>
          </table>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6 class="mb-0">Rekapitulasi Data Publikasi Ilmiah</h6>
        </div>
        <div class="card-body pt-3">
          <div class="table-responsive">
            <table class="table table-bordered excel-table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center">Tahun</th>
                  <th class="text-center">JNTT</th>
                  <th class="text-center">JNT</th>
                  <th class="text-center">JT</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rekapPublikasi as $row)
                  <tr>
                    <td class="text-center">{{ $row['tahun'] }}</td>
                    <td class="text-center">{{ $row['jntt'] }}</td>
                    <td class="text-center">{{ $row['jnt'] }}</td>
                    <td class="text-center">{{ $row['jt'] }}</td>
                  </tr>
                @endforeach
                <tr class="fw-bold">
                  <td class="text-center">JUMLAH</td>
                  <td class="text-center">{{ collect($rekapPublikasi)->sum('jntt') }}</td>
                  <td class="text-center">{{ collect($rekapPublikasi)->sum('jnt') }}</td>
                  <td class="text-center">{{ collect($rekapPublikasi)->sum('jt') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <h6 class="mb-3">Dokumen Pelaksanaan Pendidikan</h6>

      @foreach ($sections as $section)
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6 class="mb-0">{{ $section['title'] }}</h6>
          </div>
          <div class="card-body pt-3">
            <table id="{{ $section['id'] }}" class="table doc-table align-items-center mb-0" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center" style="width:60px">No</th>
                  <th>Nama Dokumen</th>
                  <th class="text-center" style="width:150px">Lihat Dokumen</th>
                  <th class="text-center" style="width:120px">Jumlah Data</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($section['items'] as $i => $item)
                  <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td class="text-center text-muted">Lihat Dokumen</td>
                    <td class="text-center doc-count {{ $item['count'] > 0 ? 'doc-count-filled' : '' }}">{{ $item['count'] }}</td>
                  </tr>
                @endforeach
              </tbody>
              @if ($section['id'] === 'table-penunjang')
                <tfoot>
                  <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th class="text-center">{{ $totalDokumenPelaksanaan }}</th>
                  </tr>
                </tfoot>
              @endif
            </table>
          </div>
        </div>
      @endforeach

      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6 class="mb-0">Dokumen Pendukung</h6>
        </div>
        <div class="card-body pt-3">
          <table id="table-dokumen-pendukung" class="table doc-table align-items-center mb-0" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" style="width:60px">No</th>
                <th>Nama Dokumen</th>
                <th class="text-center" style="width:150px">Lihat Dokumen</th>
                <th class="text-center" style="width:120px">Jumlah Data</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dokumenPendukung as $row)
                <tr>
                  <td class="text-center">{{ $row['no'] }}</td>
                  <td>{{ $row['nama'] }}</td>
                  <td class="text-center text-muted">Lihat Dokumen</td>
                  <td class="text-center doc-count {{ $row['count'] > 0 ? 'doc-count-filled' : '' }}">{{ $row['count'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer pt-3">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="copyright text-center text-sm text-muted text-lg-start">
            © <script>
              document.write(new Date().getFullYear())
            </script>, Arsip Fakultas Sains dan Teknologi Universitas Ibnu Sina
          </div>
        </div>
      </div>
    </div>
  </footer>
</div>

<style>
  .excel-table th {
    background-color: #f8f9fa;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
  }
  .excel-table td,
  .excel-table th {
    border-color: #dee2e6;
    font-size: 0.75rem;
    padding: 0.35rem 0.5rem;
  }
  .doc-count {
    font-weight: 600;
  }
  .doc-count-filled {
    background-color: #046B26;
    color: #fff;
  }
</style>
@endsection

@push('script')
  <script>
    $(function () {
      $('.doc-table').each(function () {
        $(this).DataTable({
          scrollX: true,
          pageLength: 10,
        });
      });
    });
  </script>
@endpush
