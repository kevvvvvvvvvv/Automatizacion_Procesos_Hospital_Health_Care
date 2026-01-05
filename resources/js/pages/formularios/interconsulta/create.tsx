import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { InterconsultaForm } from './partials/interconsulta-forms';
import { Estancia, Interconsulta, Paciente } from '@/types';
import interconsultas from '@/routes/interconsultas';

type Props = {
    paciente: Paciente;
    estancia: Estancia;
    interconsulta: Interconsulta;
};

const CreateInterconsulta: React.FC<Props> = ({ paciente, estancia, interconsulta }) => {
    
    const handleCreate = (form: any) => {
        form.post(route('pacientes.estancias.interconsultas.store', { 
            paciente: paciente.id, 
            estancia: estancia.id 
        }));
    };

    return (
        <MainLayout 
            pageTitle={`Creación de Interconsulta: ${paciente.nombre} ${paciente.apellido_paterno}`}
            link="estancias.show"
            linkParams={estancia.id}
        >
            <Head title="Crear interconsulta" />
            
            <InterconsultaForm 
                paciente={paciente}
                estancia={estancia}
                interconsulta={ interconsulta }
                onSubmit={handleCreate}
                submitLabel="Crear Interconsulta"
            />
        </MainLayout>
    );
};

export default CreateInterconsulta;