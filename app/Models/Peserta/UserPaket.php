<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPaket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(UserPaket::class, 'user_id');
    }

    public function pakets()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}
