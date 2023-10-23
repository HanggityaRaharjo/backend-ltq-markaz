<?php

namespace App\Models\Peserta;

use App\Models\Guru\kelas;
use App\Models\ProgramHarga;
use App\Models\SuperAdmin\CabangLembaga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function UserProgram()
    {
        return $this->hasMany(UserProgram::class, 'program_id');
    }

    public function ProgramDay()
    {
        return $this->belongsTo(ProgramDay::class, 'program_day_id');
    }

    public function programharga()
    {
        return $this->hasOne(ProgramHarga::class, 'program_id');
    }

    public function cabang()
    {
        return $this->belongsTo(CabangLembaga::class, 'cabang_lembaga_id');
    }
    public function kelas()
    {
        return $this->hasMany(kelas::class, 'program_id');
    }
}
