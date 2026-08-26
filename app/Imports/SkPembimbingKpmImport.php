<?php

namespace App\Imports;

use App\Models\SkPembimbingKpm;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SkPembimbingKpmImport implements ToCollection, WithHeadingRow
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

            // Find or create Dosen list (separated by comma or semicolon for multi-dosen)
            $userIds = [];
            if (!empty($row['nama_dosen'])) {
                $dosenList = preg_split('/[,;]+/', $row['nama_dosen']);
                foreach ($dosenList as $dosenName) {
                    $name = trim($dosenName);
                    if (empty($name)) continue;

                    $user = User::where('name', 'like', '%' . $name . '%')
                        ->orWhere('email', $name)
                        ->first();

                    if (!$user) {
                        $user = User::create([
                            'name'     => $name,
                            'email'    => strtolower(str_replace(' ', '', $name)) . rand(10, 99) . '@uis.ac.id',
                            'password' => bcrypt('password'),
                            'roles'    => 'dosen',
                            'fakultas' => $row['fakultas'] ?? null,
                            'homebase' => $row['prodi'] ?? null,
                        ]);
                    }
                    $userIds[] = $user->id;
                }
            }

            $skKpm = SkPembimbingKpm::create([
                'tahunakademik_id' => $tahunAkademikId,
                'nomor_sk'         => $row['nomor_sk'],
                'fakultas'         => $row['fakultas'] ?? null,
                'prodi'            => $row['prodi'] ?? null,
                'dokumen'          => $row['dokumen'],
            ]);

            if (!empty($userIds)) {
                $skKpm->users()->sync($userIds);
            }
        }
    }
}
