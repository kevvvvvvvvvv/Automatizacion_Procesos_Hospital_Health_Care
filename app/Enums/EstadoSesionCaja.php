<?php

namespace App\Enums;

enum EstadoSesionCaja: string
{
    case ABIERTA = 'abierta';
    case CERRADA = 'cerrada';
}