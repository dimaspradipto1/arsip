<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
        'fakultas',
        'homebase',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function skpembimbingakademik()
    {
        return $this->hasMany(SkPembimbingAkademik::class);
    }

    public function skpembimbingkpm()
    {
        return $this->belongsToMany(SkPembimbingKpm::class, 'sk_pembimbing_kpm_user');
    }

    public function skpengajaran()
    {
        return $this->hasMany(SkPengajaran::class, 'user_id');
    }

    public function skpembimbingtugasakhir()
    {
        return $this->hasMany(SkPembimbingTugasAkhir::class, 'user_id');
    }

    public function skpengangkatanstruktural()
    {
        return $this->hasMany(SkPengangkatanStruktural::class, 'user_id');
    }

    public function skpengujisempro()
    {
        return $this->belongsToMany(SkPengujiSempro::class, 'sk_penguji_sempro_user');
    }
}
