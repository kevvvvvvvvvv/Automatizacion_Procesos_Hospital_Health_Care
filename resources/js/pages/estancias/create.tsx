import React from 'react';
import { Paciente, Habitacion } from '@/types'; 
import { route } from 'ziggy-js';

import EstanciaForm from './partials/estancias-form';

interface Props {
    paciente: Paciente;
    habitaciones: Habitacion [];
}


const Create = ({ 
    paciente, 
    habitaciones
}: Props) => {

    const handleCreate = (form: any) => {
        form.post(route('pacientes.estancias.store',{paciente: paciente.id}));
    }

    return (
        <EstanciaForm
            paciente={paciente}
            habitaciones={habitaciones}
            onSubmit={handleCreate}
            title='Registro estancia'
        />
    );  
};



export default Create;