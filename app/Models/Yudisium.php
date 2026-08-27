<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yudisium extends Model
{
    use HasFactory;

    protected $table = 'yudisia';

    protected $fillable = [
        'tahunakademik_id',
        'ketua_id',
        'sekretaris_id',
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
        return $this->belongsTo(User::class, 'sekretaris_id');
    }
}
