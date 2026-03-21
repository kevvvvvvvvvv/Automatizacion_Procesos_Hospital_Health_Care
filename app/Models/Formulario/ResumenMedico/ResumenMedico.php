<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Formulario\FormularioInstancia;

class ResumenMedico extends Model
{
    protected $table = "resumen_medicos";
    protected $fillable = [
        'id',
        'resumen_medico',
         
    ];
    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id','id');
    }
    
}
