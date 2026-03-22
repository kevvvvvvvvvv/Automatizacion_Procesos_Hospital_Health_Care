<?php

namespace App\Enums;

enum TipoMovimientoCaja: string
{
    case INGRESO = 'ingreso';
    case EGRESO = 'egreso';
}