<?php

namespace App\Models\Peserta;

use App\Models\Guru\kelas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKelas extends Model
{
    use HasFactory;
    protected $table = 'peserta_user_kelas';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function kelas()
    {
        return $this->belongsTo(kelas::class, 'kelas_id');
    }
}
