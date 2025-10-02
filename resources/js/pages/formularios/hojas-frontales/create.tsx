import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import TextareaInput from '@/components/ui/input-text-area'; 
import InputText from '@/components/ui/input-text'; 
import { route } from 'ziggy-js';
import { FormularioCatalogo, User, Paciente, Estancia} from '@/types'; 

interface CreateFormularioProps {
	catalogo: FormularioCatalogo[];
	medicos: User[];
	paciente: Paciente;
	estancia: Estancia;
}

interface FormularioFormData {
  formulario_catalogo_id: number | string;
  medico_id: number | string;
  responsable:string;
  notas: string;
}


const Create = ({ medicos, paciente, estancia }: CreateFormularioProps) => {

  const { data, setData, post, processing, errors } = useForm<FormularioFormData>({
    formulario_catalogo_id: '',
    medico_id: '',
    notas: '',
	responsable: '',
  });


  const optionsMedicos = medicos.map(medico => ({
    value: medico.id,
    label: medico.nombre + ' ' + medico.apellido_paterno + ' ' + medico.apellido_materno
  }));

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('pacientes.estancias.hojasfrontales.store', { paciente: paciente.id, estancia: estancia.id }));
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-6 max-w-2xl mx-auto">
      <Head title="Crear Formulario" />

      <SelectInput
        label="Médico Asignado"
        options={optionsMedicos}
        value={data.medico_id}
        onChange={(value) => setData('medico_id', value)}
        error={errors.medico_id}
        placeholder="Selecciona un médico..."
      />



      <TextareaInput
        id="notas"
        name="notas"
        label="Notas Adicionales"
        value={data.notas}
        onChange={(e) => setData('notas', e.target.value)}
        placeholder="Añade notas u observaciones..."
        error={errors.notas}
        rows={4}
      />

	  <InputText
	        id="responsable"
			name="responsable"
			label="Familiar responsable"
			value={data.responsable}
			onChange={(e) => setData('responsable', e.target.value)}
			placeholder="Familiar responsable"
			error={errors.responsable}>
	  
	  </InputText>

      <PrimaryButton type="submit" disabled={processing}>
        {processing ? 'Guardando...' : 'Guardar Formulario'}
      </PrimaryButton>
    </form>
  );
};

// Layout del componente
Create.layout = (page: React.ReactElement) => {
    return (
        <MainLayout title="Registrar hoja frontal" children={page} />
    );
};

export default Create;