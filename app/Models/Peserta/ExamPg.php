<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPg extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ExamTypePG()
    {
        return $this->belongsTo(UserLevel::class, 'user_level_id');
    }
}
