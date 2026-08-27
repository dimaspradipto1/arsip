<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianAkhirSemester extends Model
{
    use HasFactory;

    protected $table = 'ujian_akhir_semesters';

    protected $fillable = [
        'tahunakademik_id',
        'ketua_id',
        'dokumen',
    ];

    public function tahunakademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahunakademik_id');
    }

    public function ketua()
    {
        return $this->belongsTo(User::class, 'ketua_id');
    }

    public function sekretaris()
    {
        return $this->belongsToMany(User::class, 'ujian_akhir_semester_sekretaris');
    }
}
