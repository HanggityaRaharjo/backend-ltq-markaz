<?php

namespace App\Models\AdminCabang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirInput extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function formulir()
    {
        return $this->belongsTo(Formulir::class, 'formulir_id');
    }
}
