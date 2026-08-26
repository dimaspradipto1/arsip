<?php

namespace App\Imports;

use App\Models\SkPembimbingTugasAkhir;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SkPembimbingTugasAkhirImport implements ToCollection, WithHeadingRow
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

            // Minimal required validation to process a valid record
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

            // 2. Resolve Dosen (User)
            $userId = null;
            if (!empty($namaDosenRaw)) {
                $user = User::where('name', 'like', '%' . $namaDosenRaw . '%')
                    ->orWhere('email', $namaDosenRaw)
                    ->first();

                if (!$user) {
                    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $namaDosenRaw));
                    $user = User::create([
                        'name'     => $namaDosenRaw,
                        'email'    => $slug . rand(10, 99) . '@uis.ac.id',
                        'password' => bcrypt('password'),
                        'roles'    => 'dosen',
                    ]);
                }
                $userId = $user->id;
            } else {
                $user = User::first();
                $userId = $user ? $user->id : 1;
            }

            // 3. Save SK Pembimbing Tugas Akhir
            SkPembimbingTugasAkhir::create([
                'tahunakademik_id' => $tahunAkademikId,
                'user_id'          => $userId,
                'nomor_sk'         => $nomorSk,
                'nama_mahasiswa'   => $namaMahasiswa,
                'npm'              => !empty($npm) ? $npm : '-',
                'dokumen'          => $dokumen,
            ]);
        }
    }
}
