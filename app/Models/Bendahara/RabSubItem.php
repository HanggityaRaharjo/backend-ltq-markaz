<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabSubItem extends Model
{
    use HasFactory;
    protected $table = 'rab_sub_item';
    protected $guarded = ['id'];

    public function subKegiatan()
    {
        return $this->belongsTo(RabSubKegiatan::class, 'nama_item');
    }
}
