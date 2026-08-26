<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkPembimbingAkademik extends Model
{
    protected $guarded = [];

    public function tahunakademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
