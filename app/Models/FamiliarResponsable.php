<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FamiliarResponsable extends Model
{
    protected $table = 'familiar_responsable';
    public $incrementing = true;
    protected $fillable = [
        'parentesco',
        'nombre_completo',
        'paciente_id',
    ];

    public function estancias():HasOne
    {
        return $this->hasOne(Estancia::class,'familiar_responsable_id');
    }

    public function pacientes():BelongsTo
    {
        return $this->belongsTo(Paciente::class,'paciente_id');
    }
}
