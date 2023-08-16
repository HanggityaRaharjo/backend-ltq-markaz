<?php

namespace App\Models\Guru;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputNilatSiswa extends Model
{
    use HasFactory;

    protected $table = 'input_nilai_siswas';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function raport()
    {
        return $this->hasOne(RaportSiswa::class, 'nilai_id');
    }
}
