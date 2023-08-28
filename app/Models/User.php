<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Guru\AbsensiPeserta;
use App\Models\Guru\BiodataGuru;
use App\Models\Guru\CutiGuru;
use App\Models\Guru\InputNilatSiswa;
use App\Models\Guru\kelas;
use App\Models\Peserta\BiodataPeserta;
use App\Models\Peserta\BuktiPembayaran;
use App\Models\Peserta\Cuti;
use App\Models\Peserta\ExamType;
use App\Models\Peserta\Pembayaran;
use App\Models\Peserta\ProgramPembayaran;
use App\Models\Peserta\RequestDay;
use App\Models\Peserta\UserKelas;
use App\Models\Peserta\UserLevel;
use App\Models\Peserta\UserPaket;
use App\Models\Peserta\UserProgram;
use App\Models\Peserta\VerifikasiPembayaran;
use App\Models\SuperAdmin\CabangLembaga;
use App\Models\TataUsaha\BiodataTataUsaha;
use App\Models\TataUsaha\Cuti as TataUsahaCuti;
use App\Models\TataUsaha\Dpp;
use App\Models\TataUsaha\Kegiatan;
use App\Models\TataUsaha\Konsumen;
use App\Models\TataUsaha\Spp;
use App\Models\TataUsaha\Ziswaf;
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
        'status',
        'cabang_lembaga_id',
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
        return [
            'roles' => $this->roles->pluck('nama_role'), // Mengambil daftar peran (roles) dari pengguna
        ];
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'user_id');
    }

    public function UserCabang()
    {
        return $this->hasMany(UserCabang::class, 'user_id');
    }

    public function biodata_peserta()
    {
        return $this->hasOne(BiodataPeserta::class, 'user_id');
    }

    public function biodata_guru()
    {
        return $this->hasOne(BiodataGuru::class, 'user_id');
    }
    public function biodata_tatausaha()
    {
        return $this->hasOne(BiodataTataUsaha::class, 'user_id');
    }

    public function BuktiPembayaran()
    {
        return $this->hasOne(BuktiPembayaran::class, 'user_id');
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

    public function CutiPeserta()
    {
        return $this->hasMany(Cuti::class, 'user_id');
    }

    public function CutiGuru()
    {
        return $this->hasMany(CutiGuru::class, 'user_id');
    }
    public function spp()
    {
        return $this->hasMany(Spp::class, 'user_id');
    }
    public function dpp()
    {
        return $this->hasMany(Dpp::class, 'user_id');
    }
    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'user_id');
    }
    public function ziswaf()
    {
        return $this->hasMany(Ziswaf::class, 'user_id');
    }
    public function CutiTataUsaha()
    {
        return $this->hasMany(TataUsahaCuti::class, 'user_id');
    }

    public function kelas()
    {
        return $this->hasMany(kelas::class, 'user_id');
    }

    public function absensi_peserta()
    {
        return $this->hasMany(AbsensiPeserta::class, 'user_id');
    }

    public function program_pembayaran()
    {
        return $this->hasMany(ProgramPembayaran::class, 'user_id');
    }

    public function examtype()
    {
        return $this->hasMany(ExamType::class, 'user_id');
    }
    public function input_nilai()
    {
        return $this->hasMany(InputNilatSiswa::class, 'user_id');
    }
    public function konsumen()
    {
        return $this->hasMany(Konsumen::class, 'user_id');
    }
    public function verifikasi()
    {
        return $this->hasOne(VerifikasiPembayaran::class, 'user_id');
    }
    public function user_kelas()
    {
        return $this->hasMany(UserKelas::class, 'user_id');
    }
}
