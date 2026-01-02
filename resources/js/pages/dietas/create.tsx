import React from 'react';
import { DietasForm } from './partials/dietas-form';
import { CategoriaDieta } from '@/types';
import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js'

import MainLayout from '@/layouts/MainLayout';


interface Props{
    categoria_dietas: CategoriaDieta[]
}

const DietasCreate = ({categoria_dietas}: Props) => {

    const handleCreate = (form: any) => {
        form.post(route('dietas.store'));
    };

    return (
        <MainLayout pageTitle='Registro de dieta' link='dashboard'>
            <Head title='Registro de dieta'/>
            <DietasForm
                onSubmit={handleCreate}
                categoria_dietas={categoria_dietas}
            />
        </MainLayout>
    );
}

export default DietasCreate;