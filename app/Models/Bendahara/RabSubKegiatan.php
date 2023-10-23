<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabSubKegiatan extends Model
{
    use HasFactory;
    protected $table = 'rab_sub_kegiatan';
    protected $guarded = ['id'];

    public function rab()
    {
        return $this->hasMany(Rab::class, 'nama_kegiatan');
    }
    public function subItem()
    {
        return $this->belongsTo(RabSubItem::class, 'nama_item');
    }
}
