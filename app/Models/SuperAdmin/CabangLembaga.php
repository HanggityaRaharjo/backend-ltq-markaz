<?php

namespace App\Models\SuperAdmin;

use App\Models\UserCabang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabangLembaga extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function UserCabang()
    {
        return $this->hasOne(UserCabang::class, 'cabang_lembaga_id');
    }
}
