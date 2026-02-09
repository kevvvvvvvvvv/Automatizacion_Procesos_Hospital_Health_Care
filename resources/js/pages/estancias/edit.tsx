import React from 'react';
import { Estancia, Paciente, Habitacion } from '@/types';
import { route } from 'ziggy-js';

import EstanciaForm from './partials/estancias-form';

interface EditEstanciaProps {
    paciente: Paciente;
    habitaciones: Habitacion[];
    estancia: Estancia;
}

const Edit = ({ 
    paciente, 
    estancia, 
    habitaciones }: EditEstanciaProps
) => {

    const handleEdit = (form: any) => {
        form.put(route('estancias.update',{estancia: estancia.id}));
    }

    return (
        <EstanciaForm
            paciente={paciente}
            habitaciones={habitaciones}
            title='Edición estancia'
            onSubmit={handleEdit}
            estancia={estancia}
        />
    );
};

export default Edit;