<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user_level()
    {
        return $this->hasMany(UserLevel::class, 'exam_id');
    }

    public function ExamPg()
    {
        return $this->belongsTo(ExamPg::class, 'exam_pg_id');
    }

    public function ExamEssai()
    {
        return $this->belongsTo(ExamEssai::class, 'exam_essai_id');
    }

    public function ExamPrak()
    {
        return $this->belongsTo(ExamPraktikum::class, 'exam_prak_id');
    }
}
