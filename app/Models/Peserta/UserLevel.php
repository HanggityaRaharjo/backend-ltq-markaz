<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function exam_type()
    {
        return $this->belongsTo(ExamType::class, 'exam_id');
    }
    public function ExamPg()
    {
        return $this->hasMany(ExamPg::class, 'user_level_id');
    }

    public function ExamEssai()
    {
        return $this->hasMany(ExamEssai::class, 'user_level_id');
    }

    public function ExamPrak()
    {
        return $this->hasMany(ExamPraktikum::class, 'user_level_id');
    }
}
