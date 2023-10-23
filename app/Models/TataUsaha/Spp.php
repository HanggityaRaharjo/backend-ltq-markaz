<?php

namespace App\Models\TataUsaha;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    use HasFactory;
    protected $table = 'spps';
    protected $guarded = ['id'];

    public function tagihan()
    {
        return $this->hasMany(TagihanSpp::class, 'spp_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
