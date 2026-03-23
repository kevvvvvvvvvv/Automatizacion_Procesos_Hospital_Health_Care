<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Caja extends Model
{
    protected $fillable = [
        'id',
        'nombre',
        'activa',
        'tipo',
    ];

    public function sesionesCaja(): HasMany
    {
        return $this->hasMany(SesionCaja::class);
    }

    public function solicitudesRealizadas(): HasMany
    {
        return $this->hasMany(SolicitudTraspaso::class, 'caja_destino_id');
    }

    // Las solicitudes donde esta caja es a la que LE PIDEN dinero (aplica mucho para Contaduría)
    public function solicitudesRecibidas():HasMany
    {
        return $this->hasMany(SolicitudTraspaso::class, 'caja_origen_id');
    }
}
