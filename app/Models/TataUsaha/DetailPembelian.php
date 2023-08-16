<?php

namespace App\Models\TataUsaha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $table = 'detail_pembelians';
    protected $guarded = ['id'];

    public function pembayaran_barang()
    {
        return $this->belongsTo(PembayaranBarang::class, 'pembayaran_id');
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
