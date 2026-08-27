@extends('layouts.dashboard.template')

@section('title', 'Edit Identitas Karya Ilmiah')

@section('content')
    <div class="container-fluid py-2 py-md-3">
        <div class="row">
            <div class="col-12">
                <div class="card mt-2 mt-md-3 shadow-sm border-radius-lg">
                    <div class="card-header pb-0 p-3 bg-transparent border-bottom">
                        <h6 class="mb-0 font-weight-bolder text-dark">Form Edit Identitas Karya Ilmiah</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('identitaskaryailmiah.update', $identitaskaryailmiah) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="tahun" class="form-label font-weight-bold text-xs text-dark">Tahun <span class="text-danger">*</span></label>
                                    <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $identitaskaryailmiah->tahun) }}" class="form-control" placeholder="Contoh: 2024" required>
                                    @error('tahun')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="kategori_publikasi" class="form-label font-weight-bold text-xs text-dark">Kategori Publikasi <span class="text-danger">*</span></label>
                                    <select name="kategori_publikasi" id="kategori_publikasi" class="form-control select2" data-placeholder="-- Pilih Kategori Publikasi --" required>
                                        <option value="">-- Pilih Kategori Publikasi --</option>
                                        @php
                                            $currentKategori = old('kategori_publikasi', $identitaskaryailmiah->kategori_publikasi);
                                        @endphp
                                        <option value="Jurnal Internasional Bereputasi" {{ $currentKategori == 'Jurnal Internasional Bereputasi' ? 'selected' : '' }}>Jurnal Internasional Bereputasi</option>
                                        <option value="Jurnal Internasional Terindeks" {{ $currentKategori == 'Jurnal Internasional Terindeks' ? 'selected' : '' }}>Jurnal Internasional Terindeks</option>
                                        <option value="Jurnal Nasional Terakreditasi" {{ $currentKategori == 'Jurnal Nasional Terakreditasi' ? 'selected' : '' }}>Jurnal Nasional Terakreditasi</option>
                                        <option value="Jurnal Nasional Tidak Terakreditasi" {{ $currentKategori == 'Jurnal Nasional Tidak Terakreditasi' ? 'selected' : '' }}>Jurnal Nasional Tidak Terakreditasi</option>
                                        <option value="Prosiding Internasional Terindeks" {{ $currentKategori == 'Prosiding Internasional Terindeks' ? 'selected' : '' }}>Prosiding Internasional Terindeks</option>
                                        <option value="Prosiding Nasional" {{ $currentKategori == 'Prosiding Nasional' ? 'selected' : '' }}>Prosiding Nasional</option>
                                    </select>
                                    @error('kategori_publikasi')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="judul_karya_ilmiah" class="form-label font-weight-bold text-xs text-dark">Judul Karya Ilmiah <span class="text-danger">*</span></label>
                                <textarea name="judul_karya_ilmiah" id="judul_karya_ilmiah" rows="2" class="form-control" placeholder="Masukkan judul lengkap karya ilmiah" required>{{ old('judul_karya_ilmiah', $identitaskaryailmiah->judul_karya_ilmiah) }}</textarea>
                                @error('judul_karya_ilmiah')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_jurnal" class="form-label font-weight-bold text-xs text-dark">Nama Jurnal <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_jurnal" id="nama_jurnal" value="{{ old('nama_jurnal', $identitaskaryailmiah->nama_jurnal) }}" class="form-control" placeholder="Masukkan nama jurnal" required>
                                    @error('nama_jurnal')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nomor_issn" class="form-label font-weight-bold text-xs text-dark">Nomor ISSN</label>
                                    <input type="text" name="nomor_issn" id="nomor_issn" value="{{ old('nomor_issn', $identitaskaryailmiah->nomor_issn) }}" class="form-control" placeholder="Contoh: 2502-1234">
                                    @error('nomor_issn')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="volume_nomor_tahun" class="form-label font-weight-bold text-xs text-dark">Volume, Nomor, Tahun</label>
                                    <input type="text" name="volume_nomor_tahun" id="volume_nomor_tahun" value="{{ old('volume_nomor_tahun', $identitaskaryailmiah->volume_nomor_tahun) }}" class="form-control" placeholder="Contoh: Vol. 6 No. 2 (2024)">
                                    @error('volume_nomor_tahun')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="indexing" class="form-label font-weight-bold text-xs text-dark">Indexing</label>
                                    <input type="text" name="indexing" id="indexing" value="{{ old('indexing', $identitaskaryailmiah->indexing) }}" class="form-control" placeholder="Contoh: Scopus Q2, Sinta 2, Google Scholar">
                                    @error('indexing')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="doi_artikel" class="form-label font-weight-bold text-xs text-dark">DOI Artikel</label>
                                <input type="text" name="doi_artikel" id="doi_artikel" value="{{ old('doi_artikel', $identitaskaryailmiah->doi_artikel) }}" class="form-control" placeholder="Contoh: 10.1234/justik.v6i2.567 atau link https://doi.org/...">
                                @error('doi_artikel')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alamat_web" class="form-label font-weight-bold text-xs text-dark">Alamat Web / URL</label>
                                <textarea name="alamat_web" id="alamat_web" rows="2" class="form-control" placeholder="Masukkan URL artikel pada website jurnal (contoh: https://journal.uis.ac.id/...)">{{ old('alamat_web', $identitaskaryailmiah->alamat_web) }}</textarea>
                                @error('alamat_web')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-2 pt-2">
                                <button type="submit" class="btn btn-primary text-white text-uppercase px-4 mb-0">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <a href="{{ route('identitaskaryailmiah.index') }}" class="btn btn-danger text-white text-uppercase px-4 mb-0">
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
