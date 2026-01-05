import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { Paciente, Estancia, Traslado } from '@/types';
import { route } from 'ziggy-js';
import PacienteCard from '@/components/paciente-card';
import { TrasladoForm } from './parcials/traslado-forms';


interface Props{
    traslado: Traslado;
    paciente: Paciente;
    estancia: Estancia;
}

const Edit = ({ traslado, paciente, estancia }: Props) => {
    const handleEdit = (form: any) => {
        form.put(route('traslados.update', {
        paciente: paciente.id,
        estancia: estancia.id,
        traslado: traslado.id

    }));
    };
    return (
        <MainLayout
        pageTitle='Edición de nota de traslado'
        link='estancias.show'
        linkParams={estancia.id}>
        <div className='space-y-6'>
            <Head title={`Editar nota de traslado: ${paciente.nombre}`}/>

            <PacienteCard
            paciente = {paciente}
            estancia = {estancia}
            />

            <TrasladoForm
                onSubmit = {handleEdit}
                traslado = {traslado}
                paciente = {paciente}
                estancia = {estancia}
                submitLabel = "Actualizar Traslado"
            />
        </div>
        </MainLayout>
    )
}
export default Edit;
