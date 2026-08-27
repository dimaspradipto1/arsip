<?php

namespace App\Imports;

use App\Models\IdentitasKaryaIlmiah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IdentitasKaryaIlmiahImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $tahun = trim((string)($row['tahun'] ?? ''));
            $judul = trim($row['judul_karya_ilmiah'] ?? $row['judul'] ?? $row['judul_artikel'] ?? '');
            $namaJurnal = trim($row['nama_jurnal'] ?? $row['jurnal'] ?? '');
            $nomorIssn = trim((string)($row['nomor_issn'] ?? $row['issn'] ?? ''));
            $volNoThn = trim((string)($row['volume_nomor_tahun'] ?? $row['volume_nomor'] ?? $row['vol_no_thn'] ?? ''));
            $doi = trim($row['doi_artikel'] ?? $row['doi'] ?? '');
            $alamatWeb = trim($row['alamat_web'] ?? $row['url'] ?? $row['link'] ?? $row['website'] ?? '');
            $indexing = trim($row['indexing'] ?? $row['indeks'] ?? $row['pengindeks'] ?? '');
            $kategori = trim($row['kategori_publikasi'] ?? $row['kategori'] ?? 'Jurnal Nasional');

            // Skip empty rows
            if (empty($judul) && empty($namaJurnal)) {
                continue;
            }

            IdentitasKaryaIlmiah::create([
                'tahun'               => !empty($tahun) ? $tahun : date('Y'),
                'judul_karya_ilmiah'  => $judul,
                'nama_jurnal'         => $namaJurnal,
                'nomor_issn'          => $nomorIssn,
                'volume_nomor_tahun'  => $volNoThn,
                'doi_artikel'         => $doi,
                'alamat_web'          => $alamatWeb,
                'indexing'            => $indexing,
                'kategori_publikasi'  => !empty($kategori) ? $kategori : '-',
            ]);
        }
    }
}
