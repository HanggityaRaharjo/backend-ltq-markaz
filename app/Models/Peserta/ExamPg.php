<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPg extends Model
{
    use HasFactory;

    protected $table = 'exam_pgs';
    protected $guarded = ['id'];

    public function ExamTypePG()
    {
        return $this->belongsTo(ExamType::class, 'exam_id');
    }
}
