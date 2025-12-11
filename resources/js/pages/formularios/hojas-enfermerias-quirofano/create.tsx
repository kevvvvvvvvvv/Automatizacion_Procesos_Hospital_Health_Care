import { Estancia, Paciente } from '@/types';
import React from 'react';
import { Head } from '@inertiajs/react';

import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';

interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
}

type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
}

const CreateHojaEnfermeriaQuirofano:CreateComponent = ({paciente, estancia}) => {

    return (
        <>
            <Head title='Inicio hoja de enfermería en quirófano'/>
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />

            

        </>

    )
}

CreateHojaEnfermeriaQuirofano.layout = (page: React.ReactElement) => {
    const { estancia } = page.props as CreateProps;

    return (
        <MainLayout
        pageTitle={`Inicio de hoja de enfermeria de quirofano`}
        link="estancias.show"
        linkParams={estancia.id} 
        >
        {page}
        </MainLayout>
    );
}

export default CreateHojaEnfermeriaQuirofano;