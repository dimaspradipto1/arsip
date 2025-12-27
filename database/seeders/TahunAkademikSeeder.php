<?php

namespace Database\Seeders;

use App\Models\TahunAkademik;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['tahun_akademik' => '2026/2027'],
            ['tahun_akademik' => '2025/2026'],
            ['tahun_akademik' => '2024/2025'],
            ['tahun_akademik' => '2023/2024'],
            ['tahun_akademik' => '2022/2023'],
            ['tahun_akademik' => '2021/2022'],
            ['tahun_akademik' => '2020/2021'],
            ['tahun_akademik' => '2019/2020'],
        ];

        foreach ($data as $value) {
            TahunAkademik::create($value);
        }
    }
}
