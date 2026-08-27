<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkPengujiSemproTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
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
                '001/SK-SEMPRO/FST/UIS/2024',
                'Ahmad Fauzi',
                '2021001001',
                '2024-09-15',
                'https://drive.google.com/file/d/1exampleID_Sempro/view?usp=sharing',
            ],
            [
                '2024/2025 GENAP',
                'Wakil Dekan 1 FST, Wakil Dekan 2 FST',
                '002/SK-SEMPRO/FST/UIS/2024',
                'Siti Nurhaliza',
                '2021001002',
                '2024-10-20',
                'https://drive.google.com/file/d/1exampleID_Sempro2/view?usp=sharing',
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
