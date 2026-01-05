import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { Interconsulta, Paciente, Estancia } from '@/types';
import { route } from 'ziggy-js';
import PacienteCard from '@/components/paciente-card';
import { InterconsultaForm } from './partials/interconsulta-forms';

interface Props {
    interconsulta: Interconsulta;
    paciente: Paciente;
    estancia: Estancia;
}

const Edit = ({ interconsulta, paciente, estancia }: Props) => {
    
    const handleEdit = (form: any) => {
        form.put(route('interconsultas.update', { 
            paciente: paciente.id, 
            estancia: estancia.id, 
            interconsulta: interconsulta.id 
        }));
    };

    return (
        <div className="space-y-6">
            <Head title={`Editar Interconsulta: ${paciente.nombre}`} />
            
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />

            <InterconsultaForm
                onSubmit={handleEdit}
                interconsulta={interconsulta}
                paciente={paciente} // Pasamos los datos para contexto si es necesario
                estancia={estancia}
                submitLabel="Actualizar Interconsulta"
            />
        </div>
    );
};

Edit.layout = (page: React.ReactNode) => {
    const { paciente, estancia } = (page as any).props as Props;
    return (
        <MainLayout 
            pageTitle={`Editando Interconsulta de: ${paciente.nombre}`} 
            link="estancias.show"
            linkParams={estancia.id}
        >
            {page}
        </MainLayout>
    );
};

export default Edit;