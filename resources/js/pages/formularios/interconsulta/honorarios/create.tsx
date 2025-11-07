import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente, Interconsulta } from '@/types';
import PacienteCard from '@/components/paciente-card';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  interconsulta: Interconsulta;
};

const CreateHonorario: React.FC<Props> = ({ paciente, estancia, interconsulta }) => {
  const { data, setData, post, processing, errors } = useForm({
    monto: '',
    descripcion: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('pacientes.estancias.interconsultas.honorarios.store', {
      paciente: paciente.id,
      estancia: estancia.id,
      interconsulta: interconsulta.id,
    }));
  };

  return (
    <>
      <PacienteCard paciente={paciente} estancia={estancia} />
      <Head title="Crear Honorario" />

      <FormLayout
        title="Registrar Nuevo Honorario"
        onSubmit={handleSubmit}
        actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Creando...' : 'Crear Honorario'}</PrimaryButton>}
      >
        <InputText
          id="monto"
          label="Monto"
          name="monto"
          type="number"
          step="0.01"
          value={data.monto}
          onChange={(e) => setData('monto', e.target.value)}
          placeholder="Ej: 1500.00"
          min={0}
          error={errors.monto}
        />
        <div className="col-span-full">
          <label htmlFor="descripcion" className="block text-sm font-medium text-gray-700 mb-1">
            Descripción
          </label>
          <textarea
            id="descripcion"
            name="descripcion"
            value={data.descripcion}
            onChange={(e) => setData('descripcion', e.target.value)}
            placeholder="Descripción del honorario..."
            rows={3}
            className={`w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition ${errors.descripcion ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.descripcion && (
            <p className="mt-1 text-xs text-red-500">{errors.descripcion}</p>
          )}
        </div>
      </FormLayout>
    </>
  );
};

CreateHonorario.layout = (page: React.ReactElement) => {
  return (
    <MainLayout pageTitle="Creación de Honorario" children={page} />
  );
};

export default CreateHonorario;
