<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $tipo_dieta
 * @property string $opcion_nombre
 * @property int $es_apto_diabetico
 * @property int $es_apto_celiaco
 * @property int $es_apto_hipertenso
 * @property int $es_apto_colecisto
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta whereEsAptoCeliaco($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta whereEsAptoColecisto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta whereEsAptoDiabetico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta whereEsAptoHipertenso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta whereOpcionNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoDieta whereTipoDieta($value)
 * @mixin \Eloquent
 */
class CatalogoDieta extends Model
{
    public $timestamps = false;
}
