<?php

namespace App\Models\AdminCabang;

use App\Models\SuperAdmin\CabangLembaga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kota extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function cabang()
    {
        return $this->hasMany(CabangLembaga::class, 'kota_id');
    }
}
