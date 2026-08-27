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

    public function buku()
    {
        return $this->hasMany(Buku::class, 'user_id');
    }

    public function hki()
    {
        return $this->hasMany(HKI::class, 'user_id');
    }

    public function laporanpenelitian()
    {
        return $this->hasMany(LaporanPenelitian::class, 'user_id');
    }

    /**
     * Accessor for roles attribute to always return an array.
     */
    public function getRolesAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        $decoded = json_decode($value, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    /**
     * Mutator for roles attribute to store as JSON array.
     */
    public function setRolesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['roles'] = json_encode(array_values(array_unique(array_filter($value))));
        } elseif (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $this->attributes['roles'] = json_encode(array_values(array_unique(array_filter($decoded))));
            } else {
                $parts = array_values(array_unique(array_filter(array_map('trim', explode(',', $value)))));
                $this->attributes['roles'] = json_encode($parts);
            }
        } else {
            $this->attributes['roles'] = json_encode([]);
        }
    }

    /**
     * Check if user has a specific role or any role in array.
     */
    public function hasRole($role): bool
    {
        $userRoles = $this->roles;
        if (!is_array($userRoles)) {
            $userRoles = (array) $userRoles;
        }

        if (is_array($role)) {
            return !empty(array_intersect($role, $userRoles));
        }

        return in_array($role, $userRoles, true);
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(...$roles): bool
    {
        $flattened = \Illuminate\Support\Arr::flatten($roles);
        return $this->hasRole($flattened);
    }

    /**
     * Check if user is solely a Dosen (read-only without administrative roles).
     */
    public function isOnlyDosen(): bool
    {
        $privilegedRoles = ['admin', 'tatausaha', 'dekan', 'wakilDekan1', 'wakilDekan2', 'kaprodi', 'sekprodi'];
        return $this->hasRole('dosen') && !$this->hasAnyRole($privilegedRoles);
    }

    /**
     * Check if user can write / edit data.
     */
    public function canWrite(): bool
    {
        return !$this->isOnlyDosen();
    }

    /**
     * Scope query to find users that have a specific role.
     */
    public function scopeWhereRole($query, string $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->whereJsonContains('roles', $role)
              ->orWhere('roles', 'LIKE', '%"' . $role . '"%')
              ->orWhere('roles', 'LIKE', '%' . $role . '%');
        });
    }

    /**
     * Scope query to find users that have any of given roles.
     */
    public function scopeWhereAnyRole($query, array $roles)
    {
        return $query->where(function ($q) use ($roles) {
            foreach ($roles as $role) {
                $q->orWhereJsonContains('roles', $role)
                  ->orWhere('roles', 'LIKE', '%"' . $role . '"%')
                  ->orWhere('roles', 'LIKE', '%' . $role . '%');
            }
        });
    }

    /**
     * Scope query to filter users by the program study (homebase) of the given user.
     */
    public function scopeProdiScope($query, $user = null)
    {
        $user = $user ?: Auth::user();
        if (!$user || $user->hasRole('admin')) {
            return $query;
        }

        if ($user->homebase) {
            return $query->where('users.homebase', $user->homebase);
        }

        return $query;
    }

    /**
     * Scope query based on role hierarchy:
     * - Admin: all data
     * - Dekan / WD1 / WD2 / TU: faculty scope
     * - Kaprodi / Sekprodi: prodi homebase scope
     */
    public function scopeAccessScope($query, $user = null)
    {
        $user = $user ?: Auth::user();
        if (!$user || $user->hasRole('admin')) {
            return $query;
        }

        if (($user->hasRole('kaprodi') || $user->hasRole('sekprodi')) && !$user->hasAnyRole(['dekan', 'wakilDekan1', 'wakilDekan2', 'tatausaha'])) {
            if ($user->homebase) {
                return $query->where('users.homebase', $user->homebase);
            }
        }

        return $this->scopeFacultyScope($query, $user);
    }

    /**
     * Scope query to filter users by the faculty of the given/authenticated user.
     */
    public function scopeFacultyScope($query, $user = null)
    {
        $user = $user ?: Auth::user();
        if (!$user || $user->hasRole('admin')) {
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
