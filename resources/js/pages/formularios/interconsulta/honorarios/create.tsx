import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; // Asume que tienes un componente SelectInput
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Interconsulta } from '@/types'; // Ajusta según tus tipos

type Props = {
  interconsulta?: Interconsulta | null; // Opcional, si se pasa desde el controlador
};

const Create: React.FC<Props> = ({ interconsulta }) => {
  const { data, setData, post, processing, errors } = useForm({
    interconsulta_id: interconsulta?.id || '',
    monto: '',
    descripcion: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('honorarios.store'));
  };

  // Opciones para el select de interconsultas (si no se pasa interconsulta específica)
  const interconsultaOptions = [
    // Aquí deberías cargar las interconsultas desde props o una API, e.g., { value: id, label: 'Interconsulta ' + id }
    // Por simplicidad, asumo que las cargas dinámicamente o las pasas como prop adicional.
  ];

  const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;
  const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;

  return (
    <>
      <Head title="Crear Honorario" />

      <FormLayout
        title="Registrar Nuevo Honorario"
        onSubmit={handleSubmit}
        actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Creando...' : 'Crear Honorario'}</PrimaryButton>}
      >
        {/* Si hay interconsulta específica, mostrarla; de lo contrario, select */}
        {interconsulta ? (
          <div className="col-span-full">
            <p className="text-sm text-gray-600">
              Honorario para Interconsulta: {interconsulta.id} {/* O un campo descriptivo, e.g., paciente.nombre */}
            </p>
          </div>
        ) : (
          <SelectInput
            label="Interconsulta"
            options={interconsultaOptions}
            value={data.interconsulta_id}
            onChange={(value) => setData('interconsulta_id', value)}
            error={errors.interconsulta_id}
            placeholder="Selecciona una interconsulta"
          />
        )}

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
          required
        />

        <div className="col-span-full">
          <label htmlFor="descripcion" className={labelClasses}>
            Descripción (Opcional)
          </label>
          <textarea
            id="descripcion"
            name="descripcion"
            value={data.descripcion}
            onChange={(e) => setData('descripcion', e.target.value)}
            placeholder="Descripción del honorario..."
            rows={3}
            className={`${textAreaClasses} ${errors.descripcion ? 'border-red-500' : 'border-gray-600'}`}
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

Create.layout = (page: React.ReactElement) => {
  return (
    <MainLayout pageTitle="Creación de Honorario" children={page} />
  );
};

export default Create;
