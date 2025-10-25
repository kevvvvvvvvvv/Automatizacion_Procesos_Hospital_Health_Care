import React, { useState } from 'react'; // <-- Importar useState
import { Paciente, Estancia } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; 
import { route } from 'ziggy-js';
import InputTextArea from '@/components/ui/input-text-area';

interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
}

const opcionesEstadoConciencia = [
    { value: 'Alerta', label: 'Alerta' },
    { value: 'Letárgico', label: 'Letárgico' },
    { value: 'Obnubilado', label: 'Obnubilado' },
    { value: 'Estuporoso', label: 'Estuporoso' },
    { value: 'Coma', label: 'Coma' },
];

const opcionesViaMedicamento = [
    // --- Vías Comunes ---
    { value: 'Vía Oral', label: 'Oral' },
    { value: 'Intravenosa', label: 'Intravenosa' },
    { value: 'Intramuscular', label: 'Intramuscular' },
    { value: 'Subcutánea', label: 'Subcutánea' },
    { value: 'Sublingual', label: 'Sublingual' },
    { value: 'Rectal', label: 'Rectal' },

    // --- Vías Tópicas/Otras ---
    { value: 'Tópico', label: 'Tópico' },
    { value: 'Oftálmico', label: 'Oftálmico' },
    { value: 'Otológico', label: 'Otológico' },
    { value: 'Nasal', label: 'Nasal' },

    // --- Vías Respiratorias ---
    { value: 'Nebulizado', label: 'Nebulizado' },
];

type SeccionHoja = 'signos' | 'medicamentos' | 'terapia_iv' | 'estudios' | 'sondas' | 'liquidos' | 'dieta' | 'observaciones';

const secciones: { id: SeccionHoja, label: string }[] = [
    { id: 'signos', label: 'Tomar Signos' },
    { id: 'medicamentos', label: 'Ministración de Medicamentos' },
    { id: 'terapia_iv', label: 'Terapia Intravenosa' },
    { id: 'estudios', label: 'Ordenar Estudios' },
    { id: 'sondas', label: 'Sondas y Catéteres' },
    { id: 'liquidos', label: 'Control de Líquidos' },
    { id: 'dieta', label: 'Dieta' },
    { id: 'observaciones', label: 'Observaciones' },
];


type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const Create: CreateComponent = ({ paciente, estancia }) => {

    const [activeSection, setActiveSection] = useState<SeccionHoja>('signos');

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
        medicamento_nombre: '',
        medicamento_dosis: '',
        medicamento_via: '',
        medicamento_observaciones: '',
        terapia_tipo_solucion: '',
        terapia_flujo_ml_hr: '',
        terapia_sitio_insercion: '',
        estudio_solicitado: '',
        estudio_motivo: '',
        sonda_tipo: '', 
        sonda_calibre: '',
        sonda_observaciones: '',
        liquidos_ingeridos_ml: '',
        liquidos_eliminados_ml: '',
        liquidos_balance: '', 
        dieta_tipo: '',
        dieta_tolerancia: '', 
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('pacientes.estancias.hojas-enfermeria.store', { 
            paciente: paciente.id, 
            estancia: estancia.id 
        }));
    }

    const NavigationTabs = () => (
        <nav className="mb-6 -mt-2">
            <div className="border-b border-gray-200">
                <div className="flex flex-wrap -mb-px gap-x-6 gap-y-2" aria-label="Tabs">
                    {secciones.map((seccion) => (
                        <button
                            key={seccion.id}
                            type="button" 
                            onClick={() => setActiveSection(seccion.id)}
                            className={`
                                ${activeSection === seccion.id
                                    ? 'border-blue-500 text-blue-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                }
                                whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm transition-colors duration-150
                            `}
                        >
                            {seccion.label}
                        </button>
                    ))}
                </div>
            </div>
        </nav>
    );

    const SignosVitalesContent = () => (
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
    );

    const MedicamentosContent = () => (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <InputText 
                id= ""
                name=""
                label="Medicamento" 
                value={data.medicamento_nombre} 
                onChange={e => setData('medicamento_nombre', e.target.value)} 
                error={errors.medicamento_nombre}
            />
            <InputText 
                label="Dosis" 
                value={data.medicamento_dosis} 
                onChange={e => setData('medicamento_dosis', e.target.value)} 
                error={errors.medicamento_dosis}
            />
            <SelectInput
                label="Vía de Administración"
                options={opcionesViaMedicamento}
                value={data.medicamento_via}
                onChange={(value) => setData('medicamento_via', value as string)}
                error={errors.medicamento_via}
            />
            <div className="md:col-span-3">
                <InputTextArea 
                    label="Observaciones"
                    value={data.medicamento_observaciones}
                    onChange={e => setData('medicamento_observaciones', e.target.value)}
                    error={errors.medicamento_observaciones}
                />
            </div>
        </div>
    );

    const TerapiaIVContent = () => (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <InputText 
                label="Tipo de Solución" 
                value={data.terapia_tipo_solucion} 
                onChange={e => setData('terapia_tipo_solucion', e.target.value)} 
                error={errors.terapia_tipo_solucion}
            />
            <InputText 
                label="Flujo (ml/hr)" 
                type="number"
                value={data.terapia_flujo_ml_hr} 
                onChange={e => setData('terapia_flujo_ml_hr', e.target.value)} 
                error={errors.terapia_flujo_ml_hr}
            />
            <InputText 
                label="Sitio de Inserción" 
                value={data.terapia_sitio_insercion} 
                onChange={e => setData('terapia_sitio_insercion', e.target.value)} 
                error={errors.terapia_sitio_insercion}
            />
        </div>
    );

    const renderActiveSection = () => {
        switch (activeSection) {
            case 'signos':
                return <SignosVitalesContent />;
            case 'medicamentos':
                return <MedicamentosContent />;
            case 'terapia_iv':
                return <TerapiaIVContent />;
            case 'estudios':
                return (
                    <div>
                        <InputText 
                            label="Estudio Solicitado" 
                            value={data.estudio_solicitado} 
                            onChange={e => setData('estudio_solicitado', e.target.value)} 
                            error={errors.estudio_solicitado}
                        />
                    </div>
                );
            case 'sondas':
                return <div><p>Campos para Sondas y Catéteres...</p></div>;
            case 'liquidos':
                return <div><p>Campos para Control de Líquidos...</p></div>;
            case 'dieta':
                return <div><p>Campos para Dieta...</p></div>;
            default:
                return null;
        }
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
                <NavigationTabs />
                
                <div className="mt-4">
                    {renderActiveSection()}
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