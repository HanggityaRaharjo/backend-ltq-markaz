<?php

namespace App\Models\Peserta;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiPembayaran extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_pembayarans';
    protected $guarded = ['id'];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
