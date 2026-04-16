<?php

namespace App\Enums;

enum TipoEgresoLiquido: string {
    case DIURESIS = 'diuresis';
    case SANGRADO = 'sangrado';
    case OTRO = 'otro';
    
    case EMESIS = 'emesis';
    case EVACUACION = 'evacuacion';
    case DRENAJE = 'drenaje';
}