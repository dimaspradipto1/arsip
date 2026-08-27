<?php

namespace App\Imports;

use App\Models\LaporanPenelitian;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LaporanPenelitianImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $tahunKegiatan = trim($row['tahun_kegiatan'] ?? $row['tahunkegiatan'] ?? $row['tahun'] ?? '');
            $namaDosenRaw = trim($row['nama_dosen'] ?? $row['dosen'] ?? $row['nama'] ?? $row['peneliti'] ?? '');
            $judulPenelitian = trim($row['judul_penelitian'] ?? $row['judul'] ?? $row['judulpenelitian'] ?? '');
            $dokumen = trim($row['dokumen'] ?? $row['link_dokumen'] ?? $row['link'] ?? $row['url'] ?? '');

            // Skip empty rows
            if (empty($judulPenelitian) || empty($dokumen)) {
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

            LaporanPenelitian::create([
                'tahun_kegiatan'   => !empty($tahunKegiatan) ? $tahunKegiatan : date('Y'),
                'user_id'          => $userId,
                'judul_penelitian' => $judulPenelitian,
                'dokumen'          => $dokumen,
            ]);
        }
    }
}
