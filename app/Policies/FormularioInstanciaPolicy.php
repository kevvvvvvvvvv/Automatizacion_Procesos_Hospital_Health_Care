<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Formulario\FormularioInstancia;

class FormularioInstanciaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(User $user, FormularioInstancia $instancia)
    {
        if ($user->hasRole('administrador')) return true;

        // 2. El dueño original siempre puede
        if ($instancia->user_id === $user->id) return true;

        // 3. Caso especial: Hoja de solicitud de estudios (ID 15)
        if ($instancia->catalogo_id === 15) {
            return $user->hasAnyRole(['técnico de laboratorio', 'químico', 'radiólogo']);
        }

        //Relevo en la hoja de enfermeria
        return $instancia->relevos()->where('user_id', $user->id)->whereNull('hora_salida')->exists();

        return false;
    }
}
