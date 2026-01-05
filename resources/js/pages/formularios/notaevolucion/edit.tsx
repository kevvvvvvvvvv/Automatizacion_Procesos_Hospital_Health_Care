import React from 'react';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { CatalogoEstudio, Estancia, Paciente, ProductoServicio, notasEvoluciones } from '@/types';  
import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';
import { EvolucionForm } from './partials/evolucion-form';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  evolucion? :notasEvoluciones;

};

const Edit = ({evolucion, paciente, estancia}: Props) =>{
    const handleEdit = (form: any) => {
        form.put(route('notasevoluciones.update'), {
            estancia: estancia.id,
            paciente: paciente.id,
            evolucion: evolucion?.id,
            
        })
    };
    return (
        <MainLayout
        pageTitle='Edición de la nota de evolución'
        link='estancias.show'
        linkParams={estancia.id}>
            <div className='space-y-6'>
                <Head title={`Editar nota de evolción: ${paciente.nombre}`}/>
                <PacienteCard
                paciente = {paciente}
                estancia = {estancia}
                />

                <EvolucionForm
                onSubmit={handleEdit}
                evolucion={evolucion}
                paciente={paciente}
                estancia={estancia}
                submitLabel='Actualizar nota de evolusción'
                />
            </div>
        </MainLayout>
    );
}
export default Edit;