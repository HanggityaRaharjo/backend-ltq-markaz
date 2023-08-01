<?php

namespace App\Models;

use App\Models\SuperAdmin\CabangLembaga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCabang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cabang()
    {
        return $this->belongsTo(CabangLembaga::class, 'cabang_lembaga_id');
    }
}
