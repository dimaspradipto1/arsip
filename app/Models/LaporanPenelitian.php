<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenelitian extends Model
{
    use HasFactory;

    protected $table = 'laporan_penelitians';

    protected $fillable = [
        'tahun_kegiatan',
        'user_id',
        'judul_penelitian',
        'dokumen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
