<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkPembimbingAkademikTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
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
                'Dosen FST',
                '001/SK-PA/FST/UIS/2024',
                'FAKULTAS SAINS DAN TEKNOLOGI (FST)',
                'S1-TEKNIK INFORMATIKA',
                'https://drive.google.com/file/d/1exampleID_PA/view?usp=sharing',
            ],
            [
                '2024/2025 GENAP',
                'Dekan FST',
                '002/SK-PA/FST/UIS/2024',
                'FAKULTAS SAINS DAN TEKNOLOGI (FST)',
                'S1-SISTEM INFORMASI',
                'https://drive.google.com/file/d/1exampleID_PA2/view?usp=sharing',
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
