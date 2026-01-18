<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_solicita_id
 * @property string $fecha_estudio
 * @property string $estudio_solicitado
 * @property string|null $biopsia_pieza_quirurgica
 * @property string|null $revision_laminillas
 * @property string|null $estudios_especiales
 * @property string|null $pcr
 * @property string $pieza_remitida
 * @property string|null $datos_clinicos
 * @property string|null $empresa_enviar
 * @property string|null $resultados
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereBiopsiaPiezaQuirurgica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereDatosClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereEmpresaEnviar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereEstudioSolicitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereEstudiosEspeciales($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereFechaEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia wherePcr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia wherePiezaRemitida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereResultados($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereRevisionLaminillas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudPatologia whereUserSolicitaId($value)
 * @mixin \Eloquent
 */
class SolicitudPatologia extends Model
{
    protected $table = 'solicitud_patologias';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_solicita_id',
        'fecha_estudio',
        'estudio_solicitado',
        'biopsia_pieza_quirurgica',
        'revision_laminillas',
        'estudios_especiales',
        'pcr',
        'pieza_remitida',
        'datos_clinicos',
        'empresa_enviar',
        'resultados',
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
