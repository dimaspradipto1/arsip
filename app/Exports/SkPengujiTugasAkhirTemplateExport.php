<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkPengujiTugasAkhirTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'tahun_akademik',
            'nama_dosen',
            'nomor_sk',
            'nama_mahasiswa',
            'npm',
            'tanggal_sk',
            'dokumen',
        ];
    }

    public function array(): array
    {
        return [
            [
                '2024/2025 GANJIL',
                'Dosen FST, Dekan FST',
                '001/SK-PENGUJI-TA/FST/UIS/2024',
                'Budi Santoso',
                '2021001003',
                '2024-11-10',
                'https://drive.google.com/file/d/1exampleID_PengujiTA/view?usp=sharing',
            ],
            [
                '2024/2025 GENAP',
                'Wakil Dekan 1 FST, Wakil Dekan 2 FST',
                '002/SK-PENGUJI-TA/FST/UIS/2024',
                'Dewi Lestari',
                '2021001004',
                '2024-12-05',
                'https://drive.google.com/file/d/1exampleID_PengujiTA2/view?usp=sharing',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF046B26']
                ]
            ],
        ];
    }
}
