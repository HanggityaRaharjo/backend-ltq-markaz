<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketPeserta extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function UserPaket()
    {
        return $this->hasMany(UserPaket::class, 'paket_id');
    }
}
