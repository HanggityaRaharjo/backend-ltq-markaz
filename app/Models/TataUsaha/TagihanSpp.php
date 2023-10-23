<?php

namespace App\Models\TataUsaha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanSpp extends Model
{
    use HasFactory;
    protected $table = 'tagihan_spp';
    protected $guarded = ['id'];

    public function spp()
    {
        return $this->belongsTo(Spp::class, 'spp_id');
    }
}
