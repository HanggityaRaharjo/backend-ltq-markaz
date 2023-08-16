<?php

namespace App\Models\TataUsaha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranBarang extends Model
{
    use HasFactory;
    protected $table = 'pembayaran_barangs';
    protected $guarded = ['id'];

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'konsumen_id');
    }
    public function detail_pembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'pembayaran_id');
    }
}
