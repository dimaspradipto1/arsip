<?php

namespace App\Imports;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BukuImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $tahunTerbit = trim($row['tahun_terbit'] ?? $row['tahunterbit'] ?? $row['tahun'] ?? '');
            $namaDosenRaw = trim($row['nama_dosen'] ?? $row['dosen'] ?? $row['nama'] ?? $row['penulis'] ?? '');
            $isbn = trim($row['isbn'] ?? $row['no_isbn'] ?? $row['nomor_isbn'] ?? '');
            $penerbit = trim($row['penerbit'] ?? '');
            $judulBuku = trim($row['judul_buku'] ?? $row['judul'] ?? $row['judulbuku'] ?? '');
            $dokumen = trim($row['dokumen'] ?? $row['link_dokumen'] ?? $row['link'] ?? $row['url'] ?? '');

            // Skip empty rows
            if (empty($judulBuku) || empty($dokumen)) {
                continue;
            }

            // Resolve Dosen (User)
            $userId = null;
            if (!empty($namaDosenRaw)) {
                $user = User::where('name', 'like', '%' . $namaDosenRaw . '%')
                    ->orWhere('email', $namaDosenRaw)
                    ->first();

                if (!$user) {
                    $slug = \Illuminate\Support\Str::slug($namaDosenRaw, '');
                    $user = User::create([
                        'name'      => $namaDosenRaw,
                        'email'     => ($slug ?: 'dosen') . rand(10, 99) . '@uis.ac.id',
                        'password'  => bcrypt('password'),
                        'roles'     => 'dosen',
                    ]);
                }
                $userId = $user->id;
            } else {
                $user = User::first();
                $userId = $user ? $user->id : 1;
            }

            Buku::create([
                'tahun_terbit' => !empty($tahunTerbit) ? $tahunTerbit : date('Y'),
                'user_id'      => $userId,
                'isbn'         => !empty($isbn) ? $isbn : '-',
                'penerbit'     => !empty($penerbit) ? $penerbit : '-',
                'judul_buku'   => $judulBuku,
                'dokumen'      => $dokumen,
            ]);
        }
    }
}
