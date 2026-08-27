<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkPengujiTugasAkhir extends Model
{
    use HasFactory;

    protected $table = 'sk_penguji_tugas_akhirs';

    protected $fillable = [
        'tahunakademik_id',
        'nomor_sk',
        'nama_mahasiswa',
        'npm',
        'tanggal_sk',
        'dokumen',
    ];

    protected $casts = [
        'tanggal_sk' => 'date',
    ];

    public function tahunakademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahunakademik_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'sk_penguji_tugas_akhir_user');
    }
}

