<?php
namespace App\Models;

use App\Models\Estudio\SolicitudEstudio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paquete extends Model
{
    protected $fillable = [
        'solicitud_estudio_id',
        'catalogo_estudio_id',
        'otro_estudio',
        'departamento_destino',
        'estado'
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
    public function catalogoEstudio(): BelongsTo
    {
        return $this->belongsTo(CatalogoEstudio::class);
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