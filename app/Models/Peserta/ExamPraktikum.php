<?php

namespace App\Models\Peserta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPraktikum extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ExamTypePrak()
    {
        return $this->hasMany(ExamType::class, 'exam_prak_id');
    }
}
