import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import { TrasladoForm } from './parcials/traslado-forms';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente, Traslado } from '@/types';
import PacienteCard from '@/components/paciente-card';
import traslados from '@/routes/traslados';


type Props = {
  paciente: Paciente;
  estancia: Estancia;
  traslado: Traslado;
};

const CreateTranslado: React.FC<Props> = ({ paciente, estancia, traslado }) => {
   

  const handleCreate = (form: any) => {
    
      form.post(route('pacientes.estancias.traslados.store', {
        paciente: paciente.id,
        estancia: estancia.id,
      }));
  };

  return (
    <MainLayout
    pageTitle={`Creación de nota de traslado`}
      link="estancias.show"
      
      linkParams={estancia.id} >
      <PacienteCard
        paciente={paciente}
        estancia={estancia}
      />
      <Head title="Crear Traslado" />
      <TrasladoForm 
        paciente={paciente}
        estancia = {estancia}
        traslado = {traslado}
        onSubmit={ handleCreate}
        submitLabel='Crear nota de traslado'

      />
      
      
    </MainLayout>
  );
};



export default CreateTranslado;
