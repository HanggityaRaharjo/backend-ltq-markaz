<?php

namespace App\Models\Peserta;

use App\Models\ProgramHarga;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgram extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function program_harga()
    {
        return $this->belongsTo(ProgramHarga::class, 'program_harga_id');
    }
}
