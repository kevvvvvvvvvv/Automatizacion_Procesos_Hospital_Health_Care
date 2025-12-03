import React from 'react';
import { Paciente, Estancia } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';
import SelectInput from '@/components/ui/input-select'; 
import InputTextArea from '@/components/ui/input-text-area';
import { route } from 'ziggy-js';


interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
}

const opcionesTurno = [
    { value: 'Matutino', label: 'Matutino' },
    { value: 'Vespertino', label: 'Vespertino' },
    { value: 'Nocturno', label: 'Nocturno' },
];

type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const Create: CreateComponent = ({ paciente, estancia }) => {

    const { data, setData, post, processing, errors } = useForm({
        turno: 'Matutino',
        observaciones: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('pacientes.estancias.hojasenfermerias.store', { 
            paciente: paciente.id, 
            estancia: estancia.id 
        }));
    }

    return (
        <> 
            <Head title="Iniciar Hoja de Enfermería" />
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />
            <FormLayout
                title="Iniciar nueva hoja de enfermería"
                onSubmit={handleSubmit}
                actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Iniciando...' : 'Iniciar Turno'}</PrimaryButton>}
            >
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <SelectInput
                        label="Turno"
                        options={opcionesTurno}
                        value={data.turno}
                        onChange={(value) => setData('turno', value as string)}
                        error={errors.turno}
                    />
                    
                    <div className="md:col-span-2">
                        <InputTextArea 
                            label="Observaciones Generales (Opcional)"
                            value={data.observaciones}
                            onChange={e => setData('observaciones', e.target.value)}
                            error={errors.observaciones}
                        />
                    </div>
                </div>
            </FormLayout>
        </>
    );
}

Create.layout = (page: React.ReactElement) => {
    const { estancia, paciente } = page.props as CreateProps;

  return (
    <MainLayout
      pageTitle={`Creación de hoja de enfermeria`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      {page}
    </MainLayout>
  );
}

export default Create;

