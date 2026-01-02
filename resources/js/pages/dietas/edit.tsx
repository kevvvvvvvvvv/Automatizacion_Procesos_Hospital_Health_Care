import React from 'react';
import { DietasForm } from './partials/dietas-form';
import { CategoriaDieta, Dieta } from '@/types';
import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js'

import MainLayout from '@/layouts/MainLayout';


interface Props{
    categoria_dietas: CategoriaDieta[];
    dieta: Dieta;
}

const DietasEdit = ({categoria_dietas, dieta}: Props) => {

    const handleEdit = (form: any) => {
        form.put(route('dietas.update',{dieta: dieta.id}));
    };

    return (
        <MainLayout pageTitle='Edición de dieta' link='dashboard'>
            <Head title='Edición de dieta'/>
            <DietasForm
                onSubmit={handleEdit}
                categoria_dietas={categoria_dietas}
                dieta={dieta}
            />
        </MainLayout>
    );
}

export default DietasEdit;