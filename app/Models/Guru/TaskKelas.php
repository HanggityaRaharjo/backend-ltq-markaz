<?php

namespace App\Models\Guru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskKelas extends Model
{
    use HasFactory;
    protected $table = 'task_kelas';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(kelas::class, 'kelas_id');
    }
}
