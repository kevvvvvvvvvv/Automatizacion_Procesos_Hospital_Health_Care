<?php

namespace App\Models\Formulario\Paquete;

use App\Models\Estudio\SolicitudEstudio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paquete extends Model
{
    // Esta línea es la que permite que el Controller guarde los datos
    protected $fillable = [
        'formulario_instancia_id', // <--- ¡ASEGÚRATE QUE ESTE ESTÉ AQUÍ!
        'solicitud_estudio_id',
        'catalogo_estudio_id',
        'otro_estudio',
        'departamento_destino',
        'estado',
    ];


    /**
     * Relación inversa con la solicitud
     */
    public function solicitudEstudio(): BelongsTo
    {
        return $this->belongsTo(SolicitudEstudio::class);
    }

    /**
     * Relación con el catálogo (si existe)
     */
  public function catalogoEstudio()
{
    return $this->belongsTo(\App\Models\Estudio\CatalogoEstudio::class, 'catalogo_estudio_id');
}
    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    } 

    /**
     * Accesor para obtener el nombre final del estudio
     */
    public function getNombreFinalAttribute()
    {
        return $this->catalogo_estudio_id 
            ? $this->catalogoEstudio->nombre 
            : $this->otro_estudio;
    }
}