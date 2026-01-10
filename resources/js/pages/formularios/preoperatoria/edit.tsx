import React, { useEffect } from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import InputText from '@/components/ui/input-text';
import FormLayout from '@/components/form-layout';
import { Preoperatoria, Paciente, Estancia } from '@/types';
import { route } from 'ziggy-js';
import {PreOperatoriaForm} from './partials/preoperatoria-form';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';

interface Props {
  preoperatoria: Preoperatoria;
  paciente: Paciente;
  estancia: Estancia;
}



const EditPreoperatoria: React.FC<Props> = ({ preoperatoria, paciente, estancia }) => {
  console.log("Datos de la preoperatoria", estancia);
  const handleEdit = (form : any) => {
    form.put(route('preoperatorias.update', {
        paciente: paciente.id,
        estancia: estancia.id,
        preoperatoria: preoperatoria.id,
    }));
  }


  

  return (
    <MainLayout
      pageTitle={`Creación de nota preoperatoria`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      <PacienteCard paciente={paciente} estancia={estancia} />
      <Head title={`Editar Valoración Preoperatoria #${preoperatoria.id}`} />

      <PreOperatoriaForm
      onSubmit={handleEdit}
      estancia={estancia}
      paciente={paciente}
      preoperatoria={preoperatoria}
      submitLabel='Guardar'
      
      />
    </MainLayout>
  );
};


export default EditPreoperatoria;
