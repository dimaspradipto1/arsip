<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'tahun_terbit',
            'nama_dosen',
            'isbn',
            'penerbit',
            'judul_buku',
            'dokumen',
        ];
    }

    public function array(): array
    {
        return [
            [
                '2024',
                'Dr. Ahmad Fauzi, M.Kom.',
                '978-623-123-456-7',
                'Penerbit Erlangga',
                'Pengantar Kecerdasan Buatan dan Rekayasa Perangkat Lunak',
                'https://drive.google.com/file/d/1exampleID_Buku1/view?usp=sharing',
            ],
            [
                '2023',
                'Siti Rahmawati, M.T.',
                '978-602-987-654-3',
                'Deepublish',
                'Metodologi Penelitian Bidang Sains & Teknologi Terapan',
                'https://drive.google.com/file/d/1exampleID_Buku2/view?usp=sharing',
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
