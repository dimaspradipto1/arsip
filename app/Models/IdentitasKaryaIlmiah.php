<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentitasKaryaIlmiah extends Model
{
    use HasFactory;

    protected $table = 'identitas_karya_ilmiahs';

    protected $fillable = [
        'tahun',
        'judul_karya_ilmiah',
        'nama_jurnal',
        'nomor_issn',
        'volume_nomor_tahun',
        'volume',
        'nomor',
        'doi_artikel',
        'alamat_web',
        'indexing',
        'kategori_publikasi',
    ];
}

