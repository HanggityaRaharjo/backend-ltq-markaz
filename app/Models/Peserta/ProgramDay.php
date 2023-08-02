<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDay extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Program()
    {
        return $this->hasMany(Program::class, 'program_day_id');
    }
}
