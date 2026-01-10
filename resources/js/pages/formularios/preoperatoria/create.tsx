import React from 'react';
import MainLayout from '@/layouts/MainLayout';

import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente, Preoperatoria } from '@/types';
import PacienteCard from '@/components/paciente-card';
import {PreOperatoriaForm} from './partials/preoperatoria-form';
import preoperatorias from '@/routes/preoperatorias';
type Props = {
  paciente: Paciente;
  estancia: Estancia;
  preoperatoria : Preoperatoria;
};

const CreateValoracionPreoperatoria: React.FC<Props> = ({ paciente, estancia, preoperatoria }) => {
 

  const handleSubmit = (form : any) => {
      form.post(route('pacientes.estancias.preoperatorias.store', {
        paciente: paciente.id,
        estancia: estancia.id,
      }));
  };

  return (
     <MainLayout
      pageTitle={`Creación de nota preoperatoria`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      <PacienteCard paciente={paciente} estancia={estancia} />

      <Head title="Crear nota Preoperatoria" />
      <PreOperatoriaForm
      paciente={paciente}
      estancia={estancia}
      preoperatoria={preoperatoria}
      onSubmit={handleSubmit}
      submitLabel='Guardar'
      />
     
    </MainLayout>
  );
};



export default CreateValoracionPreoperatoria;
