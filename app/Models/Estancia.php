<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Auditable;

class Estancia extends Model
{
    use HasFactory, Auditable;

    protected $table = 'estancias';
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'folio',
        'fecha_ingreso',
        'fecha_egreso',
        'habitacion_id',
        'tipo_estancia',
        'modalidad_ingreso',
        'paciente_id',
        'estancia_anterior_id',
        'familiar_responsable_id',
        'created_by', 
        'updated_by'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'id');
    }

    public function estanciaAnterior(): BelongsTo
    {
        return $this->belongsTo(Estancia::class, 'estancia_anterior_id');
    }

    public function reingresos(): HasMany
    {
        return $this->hasMany(Estancia::class, 'estancia_anterior_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function formularioInstancias(): HasMany
    {
        return $this->hasMany(FormularioInstancia::class);
    }

    public function familiarResponsable():BelongsTo
    {
        return $this->belongsTo(FamiliarResponsable::class,'familiar_responsable_id');
    }

    public function habitacion():BelongsTo
    {
        return $this->belongsTo(Habitacion::class,'habitacion_id');
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }

    public function interconsultas()
    {
        return $this->hasMany(Interconsulta::class);
    }

    public function hojaSondasCateters():HasMany
    {
        return $this->hasMany(HojaSondaCateter::class);
    }


    public function notasPostoperatorias(): HasManyThrough
    {
        return $this->hasManyThrough(
            NotaPostoperatoria::class, 
            FormularioInstancia::class, 
            'estancia_id',              
            'id',                       
            'id',                       
            'id'                        
        );
    }

    public function hojaOxigenos(): HasMany
    {
        return $this->hasMany(HojaOxigeno::class);
    }
    public function Consentimiento():hasMany
    {
        return $this->hasMany(Consentimiento::class);
    } 
}
