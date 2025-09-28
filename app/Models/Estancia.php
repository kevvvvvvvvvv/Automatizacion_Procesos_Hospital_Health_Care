<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estancia extends Model
{
    use HasFactory;

    protected $table = 'estancias';
    protected $primaryKey = 'id_estancia';
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'fecha_ingreso',
        'fecha_egreso',
        'num_habitacion',
        'tipo_estancia',
        'user_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'user_id', 'id');
    }
}
