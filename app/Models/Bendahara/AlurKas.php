<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlurKas extends Model
{
    use HasFactory;
    protected $table = 'alur_kas';
    protected $guarded = ['id'];
    public function kategoriTransaksi()
    {
        return $this->belongsTo(KategoriTransaksi::class, 'ketegori_transaksi');
    }
}
