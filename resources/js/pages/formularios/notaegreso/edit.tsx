import React from 'react';
import MainLayout from '@/layouts/MainLayout';

import { EgresoForm } from './partials/egreso-form';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, notasEgresos, Paciente } from '@/types';
import PacienteCard from '@/components/paciente-card';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  egreso : notasEgresos;
};

const Edit = ({paciente, estancia, egreso}: Props) =>{
    console.log("informacion", estancia)
    const handleEdit = (form : any) => {
        form.put(route('notasegresos.update', {
            paciente:  paciente.id,
            estancia: estancia.id,
            notasegreso: egreso.id
        }));
    };


    return (
        <MainLayout
        pageTitle='Edición de la nota de egreso'
        link='estancias.show'
        linkParams={estancia.id}>
           <div className='space-y-6'>
            <Head title={`Editar nota de egreso: ${paciente.nombre}`}/>
             <PacienteCard
                    paciente={paciente}
                    estancia={estancia}
                />

                <EgresoForm
                onSubmit={handleEdit}
                paciente={paciente}
                estancia={estancia}
                egreso={egreso}
                submitLabel='Actualizar egreso'
                />
            </div> 
        </MainLayout>
    )
}
export default Edit;