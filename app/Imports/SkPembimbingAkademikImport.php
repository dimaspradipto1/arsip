<?php

namespace App\Imports;

use App\Models\SkPembimbingAkademik;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SkPembimbingAkademikImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if (empty($row['nomor_sk']) || empty($row['dokumen'])) {
                continue;
            }

            // Find or create Tahun Akademik
            $tahunAkademikId = null;
            if (!empty($row['tahun_akademik'])) {
                $ta = TahunAkademik::firstOrCreate(
                    ['tahun_akademik' => trim($row['tahun_akademik'])]
                );
                $tahunAkademikId = $ta->id;
            } else {
                $ta = TahunAkademik::first();
                $tahunAkademikId = $ta ? $ta->id : 1;
            }

            // Find Dosen by name or email
            $userId = null;
            if (!empty($row['nama_dosen'])) {
                $user = User::where('name', 'like', '%' . trim($row['nama_dosen']) . '%')
                    ->orWhere('email', trim($row['nama_dosen']))
                    ->first();

                if (!$user) {
                    $user = User::create([
                        'name'     => trim($row['nama_dosen']),
                        'email'    => strtolower(str_replace(' ', '', trim($row['nama_dosen']))) . rand(10, 99) . '@uis.ac.id',
                        'password' => bcrypt('password'),
                        'roles'    => 'dosen',
                        'fakultas' => $row['fakultas'] ?? null,
                        'homebase' => $row['prodi'] ?? null,
                    ]);
                }
                $userId = $user->id;
            } else {
                $user = User::first();
                $userId = $user ? $user->id : 1;
            }

            SkPembimbingAkademik::create([
                'tahunakademik_id' => $tahunAkademikId,
                'user_id'          => $userId,
                'nomor_sk'         => $row['nomor_sk'],
                'fakultas'         => $row['fakultas'] ?? null,
                'prodi'            => $row['prodi'] ?? null,
                'dokumen'          => $row['dokumen'],
            ]);
        }
    }
}
