<?php

namespace App\Imports;

use App\Models\KartuRencanaStudi;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KartuRencanaStudiImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $tahunAkademikRaw = trim($row['tahun_akademik'] ?? $row['tahunakademik'] ?? $row['tahun'] ?? '');
            $ketuaRaw = trim($row['ketua_panitia'] ?? $row['ketuapanitia'] ?? $row['ketua'] ?? '');
            $sekretarisRaw = trim($row['sekretaris'] ?? $row['sekretaris_panitia'] ?? '');
            $dokumen = trim($row['dokumen'] ?? $row['link_dokumen'] ?? $row['link'] ?? $row['url'] ?? '');

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

            // Resolve Ketua Panitia
            $ketuaId = null;
            if (!empty($ketuaRaw)) {
                $userKetua = User::where('name', 'like', '%' . $ketuaRaw . '%')
                    ->orWhere('email', $ketuaRaw)
                    ->first();

                if (!$userKetua) {
                    $slug = \Illuminate\Support\Str::slug($ketuaRaw, '');
                    $userKetua = User::create([
                        'name'      => $ketuaRaw,
                        'email'     => ($slug ?: 'ketua') . rand(10, 99) . '@uis.ac.id',
                        'password'  => bcrypt('password'),
                        'roles'     => 'dosen',
                    ]);
                }
                $ketuaId = $userKetua->id;
            } else {
                $userKetua = User::first();
                $ketuaId = $userKetua ? $userKetua->id : 1;
            }

            // Resolve Multi Sekretaris
            $sekretarisIds = [];
            if (!empty($sekretarisRaw)) {
                $names = preg_split('/[,;]+/', $sekretarisRaw);
                foreach ($names as $name) {
                    $trimmedName = trim($name);
                    if (empty($trimmedName)) continue;

                    $userSekretaris = User::where('name', 'like', '%' . $trimmedName . '%')
                        ->orWhere('email', $trimmedName)
                        ->first();

                    if (!$userSekretaris) {
                        $slug = \Illuminate\Support\Str::slug($trimmedName, '');
                        $userSekretaris = User::create([
                            'name'      => $trimmedName,
                            'email'     => ($slug ?: 'sekretaris') . rand(10, 99) . '@uis.ac.id',
                            'password'  => bcrypt('password'),
                            'roles'     => 'dosen',
                        ]);
                    }
                    $sekretarisIds[] = $userSekretaris->id;
                }
            } else {
                $userSekretaris = User::first();
                if ($userSekretaris) {
                    $sekretarisIds[] = $userSekretaris->id;
                }
            }

            $record = KartuRencanaStudi::create([
                'tahunakademik_id' => $tahunAkademikId,
                'ketua_panitia_id' => $ketuaId,
                'dokumen'          => $dokumen,
            ]);

            if (!empty($sekretarisIds)) {
                $record->sekretaris()->sync($sekretarisIds);
            }
        }
    }
}
