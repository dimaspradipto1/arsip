<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'tahun_terbit',
        'user_id',
        'isbn',
        'penerbit',
        'judul_buku',
        'dokumen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
