import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import { Urgenciaform } from './partials/urgencia-forms';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente, notaUrgencia } from '@/types';
import PacienteCard from '@/components/paciente-card';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  notaUrgencia: notaUrgencia;  
};

const EditNotaUrgencia: React.FC<Props> = ({ paciente, estancia, notaUrgencia }) => {
  
  const handleEdit = (form : any) => {

    form.put(route('notasurgencias.update', {
      paciente: paciente.id,
      estancia: estancia.id,
      notasurgencia: notaUrgencia.id,
    }));
  };


  return (
    <>
      <MainLayout
      pageTitle='Edición de nota de urgencia'
      link='estancias.show'
      linkParams={estancia.id}>
        <PacienteCard
          paciente={paciente}
          estancia={estancia}
        />
        <Head title="Editar Nota de Urgencia Inicial" />
        <Urgenciaform 
                onSubmit={handleEdit}
                paciente={paciente}
                estancia={estancia}
                submitLabel='Guardar'
                urgencias={notaUrgencia}
                />
      </MainLayout>
    </>
  );
};

export default EditNotaUrgencia;