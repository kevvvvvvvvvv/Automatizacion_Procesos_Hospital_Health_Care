import React from 'react';
import { Estancia } from '@/types';

import EncuestaSatisfaccionForm from './partials/encuesta-satisfacciones-form';
import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';

interface Props {
    estancia: Estancia;
}

const Create = ({
    estancia
}: Props) => {

    const handleSumbit = (form: any) => {
        form.put(route('estancias.encuesta-satisfaccions.update', { estancia: estancia.id}))
    }

    return (
        <EncuestaSatisfaccionForm
            estancia={estancia}
            title='Registro encuesta satisfacción'
            onSubmit={handleSumbit}
        />
    );
}

export default Create;