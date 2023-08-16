<?php

namespace App\Models\TataUsaha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $guarded = ['id'];

    public function detail_pembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'barang_id');
    }
}
