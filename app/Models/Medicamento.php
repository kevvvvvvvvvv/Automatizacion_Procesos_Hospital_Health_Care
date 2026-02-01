<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicamento extends Model
{
    // Si tu tabla se llama exactamente 'medicamentos', Laravel la reconoce.
    // Pero si quieres ser explícito: 
    protected $table = 'medicamentos';

    // Importante: El ID no es autoincremental aquí, viene de ProductoServicio
    public $incrementing = false;

    protected $fillable = [
        'id',
        'excipiente_activo_gramaje',
        'volumen_total',
        'nombre_comercial',
        'gramaje',
        'fraccion',
    ];

    /**
     * Relación inversa con el Producto/Servicio principal.
     */
    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class, 'id');
    }
}