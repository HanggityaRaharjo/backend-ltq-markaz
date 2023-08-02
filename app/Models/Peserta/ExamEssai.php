<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamEssai extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ExamTypeEssai()
    {
        return $this->belongsTo(UserLevel::class, 'user_level_id');
    }
}
