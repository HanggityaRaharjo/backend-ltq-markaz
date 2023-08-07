<?php

namespace App\Models\Peserta;

use App\Models\User;
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
}
