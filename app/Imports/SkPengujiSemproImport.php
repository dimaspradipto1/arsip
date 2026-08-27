<?php

namespace App\Imports;

use App\Models\SkPengujiSempro;
use App\Models\TahunAkademik;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class SkPengujiSemproImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $nomorSk = trim($row['nomor_sk'] ?? $row['nomorsk'] ?? $row['no_sk'] ?? '');
            $namaMahasiswa = trim($row['nama_mahasiswa'] ?? $row['namamahasiswa'] ?? $row['mahasiswa'] ?? '');
            $npm = trim((string) ($row['npm'] ?? $row['nim'] ?? ''));
            $dokumen = trim($row['dokumen'] ?? $row['link_dokumen'] ?? $row['link'] ?? '');
            $tahunAkademikRaw = trim($row['tahun_akademik'] ?? $row['tahunakademik'] ?? $row['tahun'] ?? '');
            $namaDosenRaw = trim($row['nama_dosen'] ?? $row['dosen'] ?? $row['nama'] ?? '');
            $tanggalSkRaw = $row['tanggal_sk'] ?? $row['tanggalsk'] ?? $row['tgl_sk'] ?? $row['tanggal'] ?? null;

            // Skip empty rows
            if (empty($nomorSk) || empty($namaMahasiswa) || empty($dokumen)) {
                continue;
            }

            // 1. Resolve Tahun Akademik
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

            // 2. Parse Tanggal SK
            $tanggalSk = Carbon::now()->toDateString();
            if (!empty($tanggalSkRaw)) {
                try {
                    if (is_numeric($tanggalSkRaw)) {
                        $tanggalSk = Carbon::instance(ExcelDate::excelToDateTimeObject($tanggalSkRaw))->toDateString();
                    } else {
                        $tanggalSk = Carbon::parse($tanggalSkRaw)->toDateString();
                    }
                } catch (\Exception $e) {
                    $tanggalSk = Carbon::now()->toDateString();
                }
            }

            // 3. Resolve Multi Dosen (Users)
            $userIds = [];
            if (!empty($namaDosenRaw)) {
                // Split by comma or semicolon
                $dosenNames = preg_split('/[,;]+/', $namaDosenRaw, -1, PREG_SPLIT_NO_EMPTY);

                foreach ($dosenNames as $dosenName) {
                    $name = trim($dosenName);
                    if (empty($name)) continue;

                    $user = User::where('name', 'like', '%' . $name . '%')
                        ->orWhere('email', $name)
                        ->first();

                    if (!$user) {
                        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
                        $user = User::create([
                            'name'      => $name,
                            'email'     => $slug . rand(10, 99) . '@uis.ac.id',
                            'password'  => bcrypt('password'),
                            'roles'     => 'dosen',
                            'fakultas'  => 'Fakultas Sains dan Teknologi',
                        ]);
                    }
                    $userIds[] = $user->id;
                }
            }

            // Fallback if no dosen parsed
            if (empty($userIds)) {
                $firstUser = User::first();
                if ($firstUser) {
                    $userIds[] = $firstUser->id;
                }
            }

            // 4. Create SK Penguji Sempro
            $skSempro = SkPengujiSempro::create([
                'tahunakademik_id' => $tahunAkademikId,
                'nomor_sk'         => $nomorSk,
                'nama_mahasiswa'   => $namaMahasiswa,
                'npm'              => !empty($npm) ? $npm : '-',
                'tanggal_sk'       => $tanggalSk,
                'dokumen'          => $dokumen,
            ]);

            // 5. Sync Multi Dosen Pivot
            if (!empty($userIds)) {
                $skSempro->users()->sync($userIds);
            }
        }
    }
}
