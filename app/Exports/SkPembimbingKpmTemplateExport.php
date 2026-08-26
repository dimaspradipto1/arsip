<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkPembimbingKpmTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'tahun_akademik',
            'nama_dosen',
            'nomor_sk',
            'fakultas',
            'prodi',
            'dokumen',
        ];
    }

    public function array(): array
    {
        return [
            [
                '2024/2025 GANJIL',
                'Dosen FST, Dekan FST',
                '001/SK-KPM/FST/UIS/2024',
                'FAKULTAS SAINS DAN TEKNOLOGI (FST)',
                'S1-TEKNIK INFORMATIKA',
                'https://drive.google.com/file/d/1exampleID_KPM/view?usp=sharing',
            ],
            [
                '2024/2025 GENAP',
                'Admin Sistem',
                '002/SK-KPM/FST/UIS/2024',
                'FAKULTAS SAINS DAN TEKNOLOGI (FST)',
                'S1-SISTEM INFORMASI',
                'https://drive.google.com/file/d/1exampleID_KPM2/view?usp=sharing',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
