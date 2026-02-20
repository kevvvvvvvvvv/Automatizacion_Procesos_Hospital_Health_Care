import React from 'react';
import { Estancia } from '@/types';

import EncuestaSatisfaccionForm from './partials/encuesta-personal-form';
import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';

interface Props {
    estancia: Estancia;
}

const Create = ({   
    estancia
}: Props) => {

   const handleSubmit = (form: any) => {
        form.post(route('estancias.encuestapersonal.store', { estancia: estancia.id }));
    };

    return (
        <EncuestaSatisfaccionForm
            estancia={estancia}
            title='Registro encuesta satisfacción del personal'
            onSubmit={handleSubmit}
        />
    );
}

export default Create;