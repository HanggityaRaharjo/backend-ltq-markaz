<?php

namespace App\Models\AdminCabang;

use App\Http\Controllers\AdminCabang\FormulirInputController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function FormulirInput()
    {
        return $this->hasMany(FormulirInput::class, 'formulir_id');
    }
}
