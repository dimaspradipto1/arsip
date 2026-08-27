<?php

namespace App\Imports;

use App\Models\IdentitasKaryaIlmiah;
use App\Models\User;
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
            $namaDosen = trim($row['nama_dosen'] ?? $row['dosen'] ?? $row['penulis'] ?? $row['nama_penulis'] ?? '');
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

            // Resolve Dosen User
            $userId = null;
            if (!empty($namaDosen)) {
                $user = User::where('name', 'like', '%' . $namaDosen . '%')
                    ->orWhere('email', $namaDosen)
                    ->first();

                if (!$user) {
                    $slug = \Illuminate\Support\Str::slug($namaDosen, '');
                    $user = User::create([
                        'name'     => $namaDosen,
                        'email'    => ($slug ?: 'dosen') . rand(10, 99) . '@uis.ac.id',
                        'password' => bcrypt('password'),
                        'roles'    => 'dosen',
                    ]);
                }
                $userId = $user->id;
            } else {
                $user = User::first();
                $userId = $user ? $user->id : 1;
            }

            IdentitasKaryaIlmiah::create([
                'user_id'             => $userId,
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
