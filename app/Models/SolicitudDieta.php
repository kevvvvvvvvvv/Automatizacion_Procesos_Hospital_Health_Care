<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudDieta extends Model
{
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'tipo_dieta',
        'opcion_seleccionada',
        'horario_solicitud',
        'user_supervisa_id',
        'horario_entrega',
        'user_entrega_id',
        'horario_operacion',
        'horario_termino',
        'horario_inicio_dieta',
    ];

    public function usuarioSupervisa()
    {
        return $this->belongsTo(User::class, 'user_supervisa_id');
    }
}
