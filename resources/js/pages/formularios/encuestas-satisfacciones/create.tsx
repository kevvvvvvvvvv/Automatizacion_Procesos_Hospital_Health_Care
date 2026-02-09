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
        form.post(route('estancias.encuesta-satisfaccions.store', { estancia: estancia.id}))
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