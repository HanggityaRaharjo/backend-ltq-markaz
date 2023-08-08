<?php

namespace App\Models\Peserta;

use App\Models\SuperAdmin\CabangLembaga;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramPembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_programs';

    protected $guarded = ['id'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    public function cabang()
    {
        return $this->belongsTo(CabangLembaga::class, 'cabang_lembaga_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id');
    }
}
