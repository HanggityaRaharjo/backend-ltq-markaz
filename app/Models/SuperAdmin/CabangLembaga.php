<?php

namespace App\Models\SuperAdmin;

use App\Models\AdminCabang\kota;
use App\Models\ProgramHarga;
use App\Models\UserCabang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabangLembaga extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function UserCabang()
    {
        return $this->hasOne(UserCabang::class, 'cabang_lembaga_id');
    }
    public function program_harga()
    {
        return $this->hasMany(ProgramHarga::class, 'cabang_lembaga_id');
    }
    public function program()
    {
        return $this->hasMany(Program::class, 'cabang_lembaga_id');
    }
    public function kota()
    {
        return $this->belongsTo(kota::class, 'kota_id');
    }
}
