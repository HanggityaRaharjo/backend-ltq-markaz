<?php

namespace App\Models\TataUsaha;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpp extends Model
{
    use HasFactory;
    protected $table = 'dpps';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
