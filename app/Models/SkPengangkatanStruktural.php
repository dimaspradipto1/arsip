<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkPengangkatanStruktural extends Model
{
    use HasFactory;

    protected $table = 'sk_pengangkatan_strukturals';

    protected $fillable = [
        'tahunakademik_id',
        'user_id',
        'nomor_sk',
        'masa_jabatan',
        'dokumen',
    ];

    public function tahunakademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahunakademik_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

