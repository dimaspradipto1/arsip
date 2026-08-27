<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuliahPengabdianMasyarakat extends Model
{
    use HasFactory;

    protected $table = 'kuliah_pengabdian_masyarakats';

    protected $fillable = [
        'tahunakademik_id',
        'ketua_panitia_id',
        'sekretaris_id',
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
        return $this->belongsTo(User::class, 'sekretaris_id');
    }
}
