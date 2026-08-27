<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IdentitasKaryaIlmiahTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'tahun',
            'nama_dosen',
            'judul_karya_ilmiah',
            'nama_jurnal',
            'nomor_issn',
            'volume_nomor_tahun',
            'doi_artikel',
            'alamat_web',
            'indexing',
            'kategori_publikasi',
        ];
    }

    public function array(): array
    {
        return [
            [
                '2024',
                'Dr. Budi Santoso, M.Kom.',
                'Analisis Performa Algoritma Machine Learning Pada Sistem Pengarsipan Digital',
                'Jurnal Sistem Informasi dan Teknologi (JUSTIK)',
                '2502-1234',
                'Vol. 6 No. 2 (2024)',
                'https://doi.org/10.1234/justik.v6i2.567',
                'https://journal.uis.ac.id/index.php/justik/article/view/567',
                'Sinta 2',
                'Jurnal Nasional Terakreditasi',
            ],
            [
                '2024',
                'Siti Rahmawati, M.T.',
                'Deep Learning Approaches for Automated Document Classification in Higher Education',
                'International Journal of Intelligent Systems and Applications',
                '2074-9090',
                'Vol. 16 No. 1 (2024)',
                'https://doi.org/10.5815/ijisa.2024.01.03',
                'http://www.mecs-press.org/ijisa/ijisa-v16-n1/IJISA-V16-N1-3.pdf',
                'Scopus Q2',
                'Jurnal Internasional Bereputasi',
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
