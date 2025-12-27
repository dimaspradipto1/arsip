<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkKepanitiaan extends Model
{
    protected $guarded = [];

    public function tahunakademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function kategorysk()
    {
        return $this->belongsTo(KategorySk::class);
    }
}
