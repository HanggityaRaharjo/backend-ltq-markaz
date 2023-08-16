<?php

namespace App\Models\Guru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaportSiswa extends Model
{
    use HasFactory;
    protected $table = 'raport_siswas';
    protected $guarded = ['id'];

    public function nilai()
    {
        return $this->belongsTo(InputNilatSiswa::class, 'nilai_id');
    }
}