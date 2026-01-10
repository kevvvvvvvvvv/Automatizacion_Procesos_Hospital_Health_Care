import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import { EgresoForm } from './partials/egreso-form';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, notasEgresos, Paciente } from '@/types';
import PacienteCard from '@/components/paciente-card';
import notasegresos from '@/routes/notasegresos';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  egreso : notasEgresos;
};

const CreateNotaEgreso: React.FC<Props> = ({ paciente, estancia, egreso }) => {


  const handleSubmit = (form : any) => {

    form.post(route('pacientes.estancias.notasegresos.store', {
        paciente: paciente.id,
        estancia: estancia.id,
      })
    );
  };


  return (
    <MainLayout 
      pageTitle={`Creación de nota de egreso`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      <PacienteCard paciente={paciente} estancia={estancia} />
      <Head title="Crear Nota de Egreso" />
        <EgresoForm
        paciente = {paciente}
        estancia={estancia}
        egreso = {egreso}
        onSubmit={handleSubmit}
        submitLabel='Guardar'
        />


     
    </MainLayout>
  );
};

export default CreateNotaEgreso;
