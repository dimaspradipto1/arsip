<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPenelitianTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'tahun_kegiatan',
            'nama_dosen',
            'judul_penelitian',
            'dokumen',
        ];
    }

    public function array(): array
    {
        return [
            [
                '2024',
                'Dr. Ahmad Fauzi, M.Kom.',
                'Pengembangan Model AI untuk Pengenalan Dokumen Otomatis',
                'https://drive.google.com/file/d/1exampleID_Penelitian1/view?usp=sharing',
            ],
            [
                '2023',
                'Siti Rahmawati, M.T.',
                'Implementasi Algoritma Optimasi pada Jaringan Logistik Perkapalan',
                'https://drive.google.com/file/d/1exampleID_Penelitian2/view?usp=sharing',
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
