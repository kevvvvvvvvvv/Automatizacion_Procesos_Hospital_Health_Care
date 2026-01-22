import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import TextareaInput from '@/components/ui/input-text-area'; 
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
  notas: string;
}

const Create = ({ medicos, paciente, estancia }: CreateFormularioProps) => {

  
  const { data, setData, post, processing, errors } = useForm<FormularioFormData>({
    formulario_catalogo_id: '',
    medico_id: '',
    notas: '',
  });

  const hasErrors = Object.keys(errors).length > 0;

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
      <Head title="Registro hoja frontal" />

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

      {hasErrors && (
        <div className="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
          <div className="flex">
            <div className="flex-shrink-0">
              <svg className="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clipRule="evenodd" />
              </svg>
            </div>
            <div className="ml-3">
              <p className="text-sm text-red-700 font-medium">
                No se han llenado los campos requeridos o estos no cuentan con la información necesaria.
              </p>
            </div>
          </div>
        </div>
      )}

      <PrimaryButton type="submit" disabled={processing}>
        {processing ? 'Guardando...' : 'Guardar'}
      </PrimaryButton>
    </form>
  );
};

Create.layout = (page: React.ReactElement) => {
   const { estancia } = page.props as CreateFormularioProps;

  return (
    <MainLayout
      pageTitle={`Registrar hoja frontal`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      {page}
    </MainLayout>
  );
};

export default Create;