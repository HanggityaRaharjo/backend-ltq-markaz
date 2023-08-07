<?php

namespace App\Models;

use App\Models\Peserta\Program;
use App\Models\Peserta\UserProgram;
use App\Models\SuperAdmin\CabangLembaga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramHarga extends Model
{
    use HasFactory;

    protected $table = 'program_hargas';

    protected $guarded = ['id'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function cabang()
    {
        return $this->belongsTo(CabangLembaga::class, 'cabang_lembaga_id');
    }

    public function user_program()
    {
        return $this->hasMany(UserProgram::class, 'program_harga_id');
    }
}
