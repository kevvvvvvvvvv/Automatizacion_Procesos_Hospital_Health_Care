import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { HojaEnfermeria, NotaPostanestesica, Paciente, Estancia } from '@/types';
import { route } from 'ziggy-js';

// Componentes de UI

import PacienteCard from '@/components/paciente-card'; 
import MainLayout from '@/layouts/MainLayout';
import { PostanestesicaForm } from './partials/postanestesica-form';

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    hoja: HojaEnfermeria;
    nota?: NotaPostanestesica | null;
}

type NotaPostanestesicaComponent = React.FC<Props> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const Edit = ({ paciente, estancia, nota = null }: Props) => {
    
    const handleSave = (form: any) => {
        
            form.post(route('pacientes.estancias.notaspostanestesicas.store', { 
                estancia: estancia.id,
                paciente: paciente.id
            }));
        }
        

    return (
        <MainLayout
      pageTitle={`Edición de nota postanestesica`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
            <Head title={nota ? 'Editar Nota Post-Anestésica' : 'Crear Nota Post-Anestésica'} />
            <PacienteCard paciente={paciente} estancia={estancia} />
            <PostanestesicaForm
                paciente={paciente}
                estancia={estancia}
                onSubmit={handleSave} // Cambié el nombre a handleSave por claridad
                nota={nota}
            />
        </MainLayout>
    );
}




export default Edit;