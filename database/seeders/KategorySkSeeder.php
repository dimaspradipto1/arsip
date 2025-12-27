<?php

namespace Database\Seeders;

use App\Models\KategorySk;
use Illuminate\Database\Seeder;

class KategorySkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategory_sk' => 'SK Penerimaan Mahasiswa Baru (PMB)'],
            ['kategory_sk' => 'SK PANITA KONVERSI'],
            ['kategory_sk' => 'SK Semester Pendek (SP)'],
            ['kategory_sk' => 'SK Kartu Rencana Studi (KRS)'],
            ['kategory_sk' => 'SK Kuliah Pengabdian Masyarakat (KPM)'],
            ['kategory_sk' => 'SK ESQ'],
            ['kategory_sk' => 'SK Yudisium'],
            ['kategory_sk' => 'SK Wisuda'],
            ['kategory_sk' => 'SK SEMINAR PROPOSAL DAN SIDANG AKHIR'],
            ['kategory_sk' => 'SK TOEFL'],
            ['kategory_sk' => 'SK BKD'],
            ['kategory_sk' => 'SK Ujian Tengah Semester (UTS)'],
            ['kategory_sk' => 'SK Ujian Akhir Semester (UAS)'],
            ['kategory_sk' => 'SK dan lainnya'],
            ['kategory_sk' => 'SK Reviewer'],
        ];

        foreach ($data as $value) {
            KategorySk::create($value);
        }
    }
}
