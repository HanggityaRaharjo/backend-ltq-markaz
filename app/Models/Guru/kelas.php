<?php

namespace App\Models\Guru;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function absensi_peserta()
    {
        return $this->hasMany(AbsensiPeserta::class, 'kelas_id');
    }
}
