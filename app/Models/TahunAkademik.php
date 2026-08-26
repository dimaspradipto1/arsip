<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $guarded = [];

    public function skkepanitiaan()
    {
        return $this->hasMany(SkKepanitiaan::class);
    }

    public function skpembimbingakademik()
    {
        return $this->hasMany(SkPembimbingAkademik::class);
    }

    public function skpembimbingkpm()
    {
        return $this->hasMany(SkPembimbingKpm::class);
    }

    public function skpengajaran()
    {
        return $this->hasMany(SkPengajaran::class, 'tahunakademik_id');
    }

    public function skpembimbingtugasakhir()
    {
        return $this->hasMany(SkPembimbingTugasAkhir::class, 'tahunakademik_id');
    }
}
