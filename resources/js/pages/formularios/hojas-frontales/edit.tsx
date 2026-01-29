import React from 'react';
import { Head, useForm} from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import TextareaInput from '@/components/ui/input-text-area';
import { route } from 'ziggy-js';
import { FormularioCatalogo, User, Paciente, Estancia } from '@/types';
import estancia from '@/routes/estancia';

interface HojaFrontal {
  id: number;
  medico_id: number;
  notas: string;
}

interface EditFormularioProps {
  catalogo: FormularioCatalogo[];
  medicos: User[];
  paciente: Paciente;
  estancia: Estancia;
  hojaFrontal: HojaFrontal; 
}


const Edit = ({ medicos, paciente, estancia, hojaFrontal }: EditFormularioProps) => {

  const { data, setData, put, processing, errors } = useForm({
    medico_id: hojaFrontal.medico_id,
    notas: hojaFrontal.notas,
  });

  const optionsMedicos = medicos.map(medico => ({
    value: medico.id,
    label: medico.nombre + ' ' + medico.apellido_paterno + ' ' + medico.apellido_materno
  }));

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    put(route('hojasfrontales.update', { 
        hojaFrontal: hojaFrontal.id 
    }));
  };

  return (
    <MainLayout 
    pageTitle='Edición hoja frontal'>
    <form onSubmit={handleSubmit} className="space-y-6 max-w-2xl mx-auto">

      <Head title="Edición hoja frontal" />

      <SelectInput
        label="Médico Asignado"
        options={optionsMedicos}
        value={String(data.medico_id)}
        onChange={(value) => setData('medico_id', Number(value))}
        error={errors.medico_id}
        placeholder="Selecciona un médico..."
      />

      <TextareaInput
        id="notas"
        name="notas"
        label="Notas Adicionales"
        value={data.notas ?? ''}
        onChange={(e) => setData('notas', e.target.value)}
        placeholder="Añade notas u observaciones..."
        error={errors.notas}
        rows={4}
      />

      <PrimaryButton type="submit" disabled={processing}>
        {processing ? 'Actualizando...' : 'Guardar Cambios'}
      </PrimaryButton>
    </form>
    </MainLayout>
  );
};



export default Edit;