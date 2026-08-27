<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkPengangkatanStrukturalTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'tahun_akademik',
            'nama_dosen',
            'nomor_sk',
            'masa_jabatan',
            'dokumen',
        ];
    }

    public function array(): array
    {
        return [
            [
                '2024/2025 GANJIL',
                'Dosen FST',
                '001/SK-STRUKTURAL/FST/UIS/2024',
                '2024 - 2028',
                'https://drive.google.com/file/d/1exampleID_Struktural/view?usp=sharing',
            ],
            [
                '2024/2025 GENAP',
                'Dekan FST',
                '002/SK-STRUKTURAL/FST/UIS/2024',
                '2024 - 2028',
                'https://drive.google.com/file/d/1exampleID_Struktural2/view?usp=sharing',
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
