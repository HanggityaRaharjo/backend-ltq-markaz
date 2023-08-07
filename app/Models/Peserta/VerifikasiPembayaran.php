<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiPembayaran extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_pembayarans';
    protected $guarded = ['id'];
    public function users()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
