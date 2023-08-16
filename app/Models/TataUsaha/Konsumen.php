<?php

namespace App\Models\TataUsaha;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    use HasFactory;
    protected $table = 'konsumens';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembayaran_barang()
    {
        return $this->hasMany(PembayaranBarang::class, 'konsumen_id');
    }
}
