<?php

namespace App\Imports;

use App\Models\HKI;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HKIImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $tahunAkademikRaw = trim($row['tahun_akademik'] ?? $row['tahunakademik'] ?? $row['tahun'] ?? '');
            $namaDosenRaw = trim($row['nama_dosen'] ?? $row['dosen'] ?? $row['nama'] ?? '');
            $nomorHki = trim($row['nomor_hki'] ?? $row['nomorhki'] ?? $row['no_hki'] ?? '');
            $dokumen = trim($row['dokumen'] ?? $row['link_dokumen'] ?? $row['link'] ?? $row['url'] ?? '');

            // Skip empty rows
            if (empty($dokumen)) {
                continue;
            }

            // Resolve Tahun Akademik
            $tahunAkademikId = null;
            if (!empty($tahunAkademikRaw)) {
                $ta = TahunAkademik::firstOrCreate(
                    ['tahun_akademik' => $tahunAkademikRaw]
                );
                $tahunAkademikId = $ta->id;
            } else {
                $ta = TahunAkademik::first();
                $tahunAkademikId = $ta ? $ta->id : 1;
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

            HKI::create([
                'tahunakademik_id' => $tahunAkademikId,
                'user_id'          => $userId,
                'nomor_hki'        => !empty($nomorHki) ? $nomorHki : null,
                'dokumen'          => $dokumen,
            ]);
        }
    }
}
