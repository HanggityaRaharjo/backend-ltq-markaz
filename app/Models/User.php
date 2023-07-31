<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Peserta\BiodataPeserta;
use App\Models\Peserta\Cuti;
use App\Models\Peserta\RequestDay;
use App\Models\Peserta\UserLevel;
use App\Models\Peserta\UserPaket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function biodata_peserta()
    {
        return $this->hasOne(BiodataPeserta::class, 'user_id');
    }

    public function user_level()
    {
        return $this->hasOne(UserLevel::class, 'user_id');
    }

    public function UserPaket()
    {
        return $this->hasMany(UserPaket::class, 'user_id');
    }

    public function UserProgram()
    {
        return $this->hasMany(UserProgram::class, 'user_id');
    }

    public function RequestDay()
    {
        return $this->hasMany(RequestDay::class, 'user_id');
    }

    public function Cuti()
    {
        return $this->hasMany(Cuti::class, 'user_id');
    }
}
