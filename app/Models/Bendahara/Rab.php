<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    use HasFactory;
    protected $table = 'rab';
    protected $guarded = ['id'];

    public function subKegiatan()
    {
        return $this->belongsTo(RabSubKegiatan::class, 'nama_kegiatan');
    }
}
