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
    nota: NotaPostanestesica;
}

type NotaPostanestesicaComponent = React.FC<Props> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const NotaPostanestesicaForm: NotaPostanestesicaComponent = ({ paciente, estancia, nota }) => {
   const handleEdit = (form: any) => {
    // El error dice que el parámetro requerido es 'notaspreanestesica'
    form.put(route('notaspostanestesicas.update', {
        notaspostanestesica: nota.id 
    }));
    };


   

    return (
        <>
            <PacienteCard paciente={paciente} estancia={estancia} />
            <Head title={'Editar Nota Post-Anestésica'} />
            <PostanestesicaForm
                paciente={paciente}
                estancia={estancia}
                onSubmit={handleEdit}
                nota={nota}
                
            />
           
        </>
    );
}

NotaPostanestesicaForm.layout = (page: React.ReactElement) => {
    const { estancia, paciente } = page.props as Props;

  return (
    <MainLayout
      pageTitle={`Edición de nota postanestesica`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      {page}
    </MainLayout>
  );
}


export default NotaPostanestesicaForm;