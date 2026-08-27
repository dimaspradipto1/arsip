<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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

    public function skpengujitugasakhir()
    {
        return $this->belongsToMany(SkPengujiTugasAkhir::class, 'sk_penguji_tugas_akhir_user');
    }

    /**
     * Scope query to filter users by the faculty of the given/authenticated user.
     */
    public function scopeFacultyScope($query, $user = null)
    {
        $user = $user ?: Auth::user();
        if (!$user || $user->roles === 'admin') {
            return $query;
        }

        $faculty = $user->fakultas;
        if (!$faculty) {
            return $query;
        }

        return $query->where(function ($q) use ($faculty) {
            $q->where('users.fakultas', $faculty);
            if (stripos($faculty, 'Sains') !== false || stripos($faculty, 'FST') !== false) {
                $q->orWhere('users.fakultas', 'LIKE', '%Sains%')
                  ->orWhere('users.fakultas', 'LIKE', '%FST%');
            } elseif (stripos($faculty, 'Kesehatan') !== false || stripos($faculty, 'FIKes') !== false) {
                $q->orWhere('users.fakultas', 'LIKE', '%Kesehatan%')
                  ->orWhere('users.fakultas', 'LIKE', '%FIKes%');
            } elseif (stripos($faculty, 'Ekonomi') !== false || stripos($faculty, 'FEB') !== false) {
                $q->orWhere('users.fakultas', 'LIKE', '%Ekonomi%')
                  ->orWhere('users.fakultas', 'LIKE', '%FEB%');
            }
        });
    }
}
