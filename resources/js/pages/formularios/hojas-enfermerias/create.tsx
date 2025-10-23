import React from 'react';
import { Paciente, Estancia } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; 
import { route } from 'ziggy-js';

interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
}


const opcionesEstadoConciencia = [
    { value: 'Alerta', label: 'Alerta' },
    { value: 'Letárgico', label: 'Letárgico' },
    { value: 'Estuporoso', label: 'Estuporoso' },
    { value: 'Coma', label: 'Coma' },
];

type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const Create: CreateComponent = ({ paciente, estancia }) => {

    const { data, setData, post, processing, errors } = useForm({
        tension_arterial: '',
        frecuencia_cardiaca: '',
        frecuencia_respiratoria: '',
        temperatura: '',
        peso: '',
        talla: '',
        saturacion_oxigeno: '',
        glucemia_capilar: '',
        estado_conciencia: '', 
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('pacientes.estancias.hojas-enfermeria.store', { 
            paciente: paciente.id, 
            estancia: estancia.id 
        }));
    }

    return (
        <> 
            <Head title="Hoja de enfermería" />
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />
            <FormLayout
                title="Registrar nueva hoja de enfermería"
                onSubmit={handleSubmit}
                actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Guardando...' : 'Guardar'}</PrimaryButton>}
            >

                <div className="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <InputText 
                        id="tension_arterial" 
                        name="tension_arterial" 
                        label="Tensión Arterial" 
                        value={data.tension_arterial} 
                        onChange={(e) => setData('tension_arterial', e.target.value)} 
                        error={errors.tension_arterial} 
                    />
                    <InputText 
                        id="frecuencia_cardiaca" 
                        name="frecuencia_cardiaca" 
                        label="Frecuencia Cardíaca (por minuto)" 
                        type="number" 
                        value={data.frecuencia_cardiaca} 
                        onChange={(e) => setData('frecuencia_cardiaca', e.target.value)} 
                        error={errors.frecuencia_cardiaca} 
                    />
                    <InputText 
                        id="frecuencia_respiratoria" 
                        name="frecuencia_respiratoria" 
                        label="Frecuencia Respiratoria (por minuto)" 
                        type="number" 
                        value={data.frecuencia_respiratoria} 
                        onChange={(e) => setData('frecuencia_respiratoria', e.target.value)} 
                        error={errors.frecuencia_respiratoria} 
                    />
                    <InputText 
                        id="temperatura" 
                        name="temperatura" 
                        label="Temperatura (Celsius)" 
                        type="number" 
                        value={data.temperatura} 
                        onChange={(e) => setData('temperatura', e.target.value)} 
                        error={errors.temperatura} 
                    />
                    <InputText 
                        id="saturacion_oxigeno" 
                        name="saturacion_oxigeno" 
                        label="Saturación de Oxígeno (porcentaje)" 
                        type="number" 
                        value={data.saturacion_oxigeno} 
                        onChange={(e) => setData('saturacion_oxigeno', e.target.value)} 
                        error={errors.saturacion_oxigeno} 
                    />
                    <InputText 
                        id="glucemia_capilar" 
                        name="glucemia_capilar" 
                        label="Glucemia Capilar" 
                        type="number" 
                        value={data.glucemia_capilar} 
                        onChange={(e) => setData('glucemia_capilar', e.target.value)} 
                        error={errors.glucemia_capilar} 
                    />
                    <InputText 
                        id="peso" 
                        name="peso" 
                        label="Peso (kilogramos)" 
                        type="number" 
                        value={data.peso} 
                        onChange={(e) => setData('peso', e.target.value)} 
                        error={errors.peso} 
                    />
                    <InputText 
                        id="talla" 
                        name="talla" 
                        label="Talla (centímetros)" 
                        type="number" 
                        value={data.talla} 
                        onChange={(e) => setData('talla', e.target.value)} 
                        error={errors.talla} 
                    />
                    
                    <SelectInput
                        label="Estado de Conciencia"
                        options={opcionesEstadoConciencia}
                        value={data.estado_conciencia}
                        onChange={(value) => setData('estado_conciencia', value as string)}
                        error={errors.estado_conciencia}
                    />
                </div>
            </FormLayout>
        </>
    );
}

Create.layout = (page: React.ReactElement) => {
    return (
        <MainLayout pageTitle='Creación de hoja de enfermería' children={page} />
    );
}

export default Create;