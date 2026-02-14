import React from 'react';
import { Estancia } from '@/types';

import EncuestaSatisfaccionForm from './partials/encuesta-satisfacciones-form';
import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';
interface Props {
    estancia: Estancia;
    encuesta: any; // O el tipo EncuestaSatisfaccion si lo tienes importado
}

const Edit = ({ encuesta, estancia }: Props) => {
    const handleUpdate = (form : any) => {
        form.put(route('encuesta-satisfaccions.update', encuesta.id));
    };

    return (
        <EncuestaSatisfaccionForm 
            encuesta={encuesta} 
            estancia={estancia} 
            title="Editar Encuesta" 
            onSubmit={handleUpdate} 
        />
    );
}
export default Edit;