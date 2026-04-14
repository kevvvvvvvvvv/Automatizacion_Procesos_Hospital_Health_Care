<?php

namespace App\Enums;

enum EstadoReservacion: string 
{
    case Pendiente = 'pendiente';
    case Programada = 'programada';
    case EnPreparacion = 'en_preparacion';
    case EnCurso = 'en_curso';
    case Finalizada = 'finalizada';
    case Cancelada = 'cancelada';

    public function colorEtiqueta(): string 
    {
        return match($this) {
            self::Pendiente => 'bg-yellow-100 text-yellow-800',
            self::Programada => 'bg-blue-100 text-blue-800',
            self::EnPreparacion => 'bg-purple-100 text-purple-800',
            self::EnCurso => 'bg-red-100 text-red-800',
            self::Finalizada => 'bg-green-100 text-green-800',
            self::Cancelada => 'bg-gray-100 text-gray-800',
        };
    }
}