<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'name',
            'email',
            'password',
            'roles',
            'fakultas',
            'homebase',
        ];
    }

    public function array(): array
    {
        return [
            [
                'Nama Dosen Contoh',
                'contohdosen@uis.ac.id',
                'password',
                'dosen',
                'FAKULTAS SAINS DAN TEKNOLOGI (FST)',
                'S1-TEKNIK INFORMATIKA',
            ],
            [
                'Dosen & Kaprodi Contoh',
                'kaprodi.contoh@uis.ac.id',
                'password',
                'dosen, kaprodi',
                'FAKULTAS SAINS DAN TEKNOLOGI (FST)',
                'S1-TEKNIK INFORMATIKA',
            ],
            [
                'Staff TU FST',
                'staff.tu@uis.ac.id',
                'password',
                'tatausaha',
                'FAKULTAS SAINS DAN TEKNOLOGI (FST)',
                'S1-SISTEM INFORMASI',
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
