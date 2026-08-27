<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BebanKerjaDosen extends Model
{
    use HasFactory;

    protected $table = 'beban_kerja_dosens';

    protected $fillable = [
        'tahunakademik_id',
        'ketua_panitia_id',
        'dokumen',
    ];

    public function tahunakademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahunakademik_id');
    }

    public function ketuaPanitia()
    {
        return $this->belongsTo(User::class, 'ketua_panitia_id');
    }

    public function sekretaris()
    {
        return $this->belongsToMany(User::class, 'beban_kerja_dosen_sekretaris');
    }
}
