import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente, notaUrgencia } from '@/types';
import PacienteCard from '@/components/paciente-card';
import { Urgenciaform } from './partials/urgencia-forms';
import EstanciaController from '@/actions/App/Http/Controllers/EstanciaController';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  urgencia:notaUrgencia;
};
const CreateNotaUrgencia: React.FC<Props> = ({ paciente, estancia, urgencia }) => {
   const { data, setData, post, processing, errors } = useForm({
       
   });
    const handleSubmit = (form : any) => {
   
    form.post(route('pacientes.estancias.notasurgencias.store', {
      paciente: paciente.id,
      estancia: estancia.id,
    }));
  };

  return (
    <><MainLayout
      pageTitle={`Creación de nota de urgencias`}
      link="estancias.show"
      
      linkParams={estancia.id} >
      <PacienteCard
        paciente={paciente}
        estancia={estancia}
      />
      <Head title="Crear Nota de Urgencia Inicial" />
        <Urgenciaform 
        onSubmit={handleSubmit}
        paciente={paciente}
        estancia={estancia}
        submitLabel='Guardar'
        urgencias={urgencia}
        />
      
      </MainLayout>
    </>
  );
};

export default CreateNotaUrgencia;