<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'name',
        'profile_picture',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function puskesmas(): HasOne
    {
        return $this->hasOne(Puskesmas::class);
    }

    public function refreshTokens(): HasMany
    {
        return $this->hasMany(UserRefreshToken::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPuskesmas(): bool
    {
        return $this->role === 'puskesmas';
    }
}