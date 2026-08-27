<?php

namespace App\Imports;

use App\Models\TahunAkademik;
use App\Models\UjianTengahSemester;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UjianTengahSemesterImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $tahunAkademikRaw = trim($row['tahun_akademik'] ?? $row['tahunakademik'] ?? $row['tahun'] ?? '');
            $ketuaRaw = trim($row['ketua'] ?? $row['ketua_panitia'] ?? $row['nama_ketua'] ?? '');
            $sekretarisRaw = trim($row['sekretaris'] ?? $row['nama_sekretaris'] ?? '');
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

            // Resolve Ketua (User)
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

            // Resolve Sekretaris (User)
            $sekretarisId = null;
            if (!empty($sekretarisRaw)) {
                $userSekretaris = User::where('name', 'like', '%' . $sekretarisRaw . '%')
                    ->orWhere('email', $sekretarisRaw)
                    ->first();

                if (!$userSekretaris) {
                    $slug = \Illuminate\Support\Str::slug($sekretarisRaw, '');
                    $userSekretaris = User::create([
                        'name'      => $sekretarisRaw,
                        'email'     => ($slug ?: 'sekretaris') . rand(10, 99) . '@uis.ac.id',
                        'password'  => bcrypt('password'),
                        'roles'     => 'dosen',
                    ]);
                }
                $sekretarisId = $userSekretaris->id;
            } else {
                $userSekretaris = User::first();
                $sekretarisId = $userSekretaris ? $userSekretaris->id : 1;
            }

            UjianTengahSemester::create([
                'tahunakademik_id' => $tahunAkademikId,
                'ketua_id'         => $ketuaId,
                'sekretaris_id'    => $sekretarisId,
                'dokumen'          => $dokumen,
            ]);
        }
    }
}
