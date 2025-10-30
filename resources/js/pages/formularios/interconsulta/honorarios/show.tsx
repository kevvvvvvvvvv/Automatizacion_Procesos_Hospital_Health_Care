import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import InputText from '@/components/ui/input-text';
import PacienteCard from '@/components/paciente-card';
import { Head } from '@inertiajs/react';
import { Estancia, Paciente, Interconsulta } from '@/types';

type Honorario = {
  id: number;
  monto: string | number;
  descripcion: string | null;
  interconsulta_id: number;
  created_at?: string;
  updated_at?: string;
};

interface ShowHonorarioProps {
  paciente: Paciente;
  estancia: Estancia;
  interconsulta: Interconsulta;
  honorario: Honorario; // <-- Asegúrate de enviar esto desde el controlador
}

const ShowHonorario: React.FC<ShowHonorarioProps> = ({ paciente, estancia, interconsulta, honorario }) => {
  return (
    <>
      <Head title="Detalles del Honorario" />
      <PacienteCard paciente={paciente} estancia={estancia} />

      <FormLayout title={`Honorarios de la Interconsulta #${interconsulta.id} de ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <InputText
            id="monto"
            name="monto"
            label="Monto"
            value={String(honorario.monto ?? '')}
            readOnly
          />
          <InputText
            id="descripcion"
            name="descripcion"
            label="Descripción"
            value={honorario.descripcion ?? ''}
            readOnly
          />
        </div>
      </FormLayout>
    </>
  );
};

ShowHonorario.layout = (page: React.ReactElement) => {
  const props = page.props as any as ShowHonorarioProps;
  return (
    <MainLayout pageTitle={`Honorario de ${props.paciente.nombre}`} children={page} />
  );
};

export default ShowHonorario;
