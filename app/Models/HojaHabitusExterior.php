<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property string $sexo
 * @property string $condicion_llegada
 * @property string $facies
 * @property string $constitucion
 * @property string $postura
 * @property string $piel
 * @property string $estado_conciencia
 * @property string $marcha
 * @property string $movimientos
 * @property string $higiene
 * @property string $edad_aparente
 * @property string $orientacion
 * @property string $lenguaje
 * @property string $olores_ruidos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HojaEnfermeria $hojaEnfermeria
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereCondicionLlegada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereConstitucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereEdadAparente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereEstadoConciencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereFacies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereHigiene($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereLenguaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereMarcha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereMovimientos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereOloresRuidos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereOrientacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior wherePiel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior wherePostura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereSexo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaHabitusExterior whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HojaHabitusExterior extends Model
{
    protected $fillable = [
        'hoja_enfermeria_id',
        'sexo',
        'condicion_llegada',
        'facies',
        'constitucion',
        'postura',
        'piel',
        'estado_conciencia',
        'marcha',
        'movimientos',
        'higiene',
        'edad_aparente',
        'orientacion',
        'lenguaje',
        'olores_ruidos',
    ];

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }
}
