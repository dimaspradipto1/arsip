<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkPembimbingKpm extends Model
{
    protected $guarded = [];

    public function tahunakademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'sk_pembimbing_kpm_user');
    }
}
