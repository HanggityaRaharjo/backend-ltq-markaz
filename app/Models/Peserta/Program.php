<?php

namespace App\Models\Peserta;

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
}
