<?php

namespace App\Imports;

use App\Models\SkPengajaran;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SkPengajaranImport implements ToCollection, WithHeadingRow
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
                    ]);
                }
                $userId = $user->id;
            } else {
                $user = User::first();
                $userId = $user ? $user->id : 1;
            }

            SkPengajaran::create([
                'tahunakademik_id' => $tahunAkademikId,
                'user_id'          => $userId,
                'nomor_sk'         => $row['nomor_sk'],
                'dokumen'          => $row['dokumen'],
            ]);
        }
    }
}
