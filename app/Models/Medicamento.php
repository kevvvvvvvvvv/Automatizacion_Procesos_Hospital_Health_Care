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

    // App\Models\Medicamento.php

    protected $fillable = [
        'id', // Importante incluir el ID ya que no es autoincremental
        'excipiente_activo_gramaje',
        'volumen_total',
        'nombre_comercial',
        'gramaje',
        'fraccion',
        
    ];
    /**
     * Relación inversa con el Producto/Servicio principal.
     */
    // App\Models\Medicamento.php
   public function vias()
{
    return $this->belongsToMany(
        CatalogoViaAdministracion::class, 
        'medicamento_vias', // Nombre de tu tabla intermedia
        'medicamento_id', 
        'catalogo_via_administracion_id'
    );
}
    public function productoServicio()
    {
        return $this->belongsTo(ProductoServicio::class, 'id', 'id');
    }

}