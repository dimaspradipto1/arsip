<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SemesterAntaraTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'tahun_akademik',
            'ketua',
            'sekretaris',
            'dokumen',
        ];
    }

    public function array(): array
    {
        return [
            [
                '2024/2025 GANJIL',
                'Dr. Ahmad Fauzi, M.Kom.',
                'Siti Rahmawati, M.T.',
                'https://drive.google.com/file/d/1exampleID_SA1/view?usp=sharing',
            ],
            [
                '2024/2025 GENAP',
                'Budi Santoso, M.Kom.',
                'Dewi Lestari, M.Si.',
                'https://drive.google.com/file/d/1exampleID_SA2/view?usp=sharing',
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
