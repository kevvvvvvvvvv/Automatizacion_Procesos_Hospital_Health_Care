<?php
class ReservacionQuirofano extends Model
{
    protected $fillable = [
        'habitacion_id',
        'user_id',
        'paciente',
        'estancia_id',
        'tratante',
        'procedimiento',
        'tiempo_estimado',
        'medico_operacion',
        'fecha',
        'horarios',
        'localizacion',
        'instrumentista',
        'anestesiologo',
        'insumos_medicamentos',
        'esterilizar_detalle',
        'rayosx_detalle',
        'patologico_detalle',
        'laparoscopia_detalle',
        'comentarios',
    ];

    protected $casts = [
        'horarios' => 'array',
        'fecha' => 'date:Y-m-d',
    ];

    /* =====================
       Relaciones
    ===================== */

    public function estancia(): BelongsTo
    {
        return $this->belongsTo(Estancia::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function habitacion(): BelongsTo
    {
        return $this->belongsTo(Habitacion::class);
    }
}
