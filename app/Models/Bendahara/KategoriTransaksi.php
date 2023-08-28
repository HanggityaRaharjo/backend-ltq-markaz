<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTransaksi extends Model
{
    use HasFactory;
    protected $table = 'kategori_transaksis';
    protected $guarded = ['id'];
    public function alurKas()
    {
        return $this->hasMany(AlurKas::class, 'ketegori_transaksi');
    }
}
