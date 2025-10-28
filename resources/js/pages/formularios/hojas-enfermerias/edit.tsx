import React, { useState } from 'react'; 
import { Paciente, Estancia, ProductoServicio, HojaEnfermeria, HojaSignosGraficas } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import PacienteCard from '@/components/paciente-card';
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; 
import InputTextArea from '@/components/ui/input-text-area';
import TerapiaIVForm from '@/components/terapia-iv-form';
import SignosVitalesForm from '@/components/signos-vitales-form';
import GraficaContent from '@/components/graphs/grafica-content'
import MedicamentosForm from '@/components/forms/medicamentos-form';

interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
    hojaenfermeria: HojaEnfermeria;
    medicamentos: ProductoServicio[];
    soluciones: ProductoServicio[];
    dataParaGraficas: HojaSignosGraficas[];
}

interface MedicamentoAgregado {
    id: string;
    nombre: string;
    dosis: string;
    via_id: string;
    via_label: string;
    duracion: string;
    inicio: string;
    temp_id: string; 
}

type SeccionHoja = 'signos' | 'medicamentos' | 'terapia_iv' | 'estudios' | 'sondas' | 'liquidos' | 'dieta' | 'observaciones' | 'graficas';

const secciones: { id: SeccionHoja, label: string }[] = [
    { id: 'signos', label: 'Tomar Signos' },
    { id: 'medicamentos', label: 'Ministración de Medicamentos' },
    { id: 'terapia_iv', label: 'Terapia Intravenosa' },
    { id: 'estudios', label: 'Ordenar Estudios' },
    { id: 'sondas', label: 'Sondas y Catéteres' },
    { id: 'liquidos', label: 'Control de Líquidos' },
    { id: 'dieta', label: 'Dieta' },
    { id: 'observaciones', label: 'Observaciones' },
    { id: 'graficas', label: 'Gráficas' },
];

const opcionesDispositivo = [
    { value: '', label: 'Seleccionar un dispositivo...' },
    { value: 'Catéter venoso central', label: 'Catéter venoso central' },
    { value: 'Sonda vesical', label: 'Sonda vesical' },
    { value: 'Sonda nasogástrica', label: 'Sonda nasogástrica' },
    { value: 'Catéter venoso', label: 'Catéter venoso' }
];

type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const Create: CreateComponent = ({ paciente, estancia, hojaenfermeria ,medicamentos, soluciones, dataParaGraficas}) => {

    const [activeSection, setActiveSection] = useState<SeccionHoja>('signos');

    const { data, setData, errors } = useForm({
        medicamento_id: '',
        medicamento_nombre: '',
        medicamento_dosis: '',
        medicamento_via: '',
        medicamento_via_label: '',
        medicamento_duracion_tratamiento: '',
        medicamento_fecha_hora_inicio: '',
        medicamentos_agregados: [] as MedicamentoAgregado[],

        tipo_dispositivo: '',
        calibre: '',
        fecha_instalacion: '',
        fecha_colocacion: '',
        observaciones: '',

        duracion: '',
        flujo:'',
        terapia_fecha_hora_inicio: '',

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

    
    
    const SondasCateteres = () => {

        const handleTipoChange = (value: string) => {
            setData(data => ({
                ...data,
                tipo_dispositivo: value,
                ...(value === '' && {
                    calibre: '',
                    fecha_instalacion: '',
                    fecha_colocacion: '',
                    observaciones: '',
                })
            }));
        };

        return (
            <div>
                <SelectInput
                    label="Tipo de Dispositivo"
                    options={opcionesDispositivo}
                    value={data.tipo_dispositivo}
                    onChange={(value) => handleTipoChange(value as string)}
                    error={errors.tipo_dispositivo}
                />

                {data.tipo_dispositivo && (
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 border-t pt-6">
                        <InputText 
                            id="calibre"
                            name="calibre"
                            label="Calibre"
                            value={data.calibre}
                            onChange={e => setData('calibre', e.target.value)}
                            error={errors.calibre}
                        />

                        <InputText 
                            id="dispositivo_fecha_instalacion"
                            name="dispositivo_fecha_instalacion"
                            label="Fecha de Instalación"
                            value={data.fecha_instalacion}
                            onChange={e => setData('fecha_instalacion', e.target.value)}
                            error={errors.fecha_instalacion}
                        />

                        <InputText 
                            id="dispositivo_fecha_colocacion"
                            name="dispositivo_fecha_colocacion"
                            label="Fecha de Colocación"
                            value={data.fecha_colocacion}
                            onChange={e => setData('fecha_colocacion', e.target.value)}
                            error={errors.fecha_colocacion}
                        />

                        <div className="md:col-span-3">
                            <InputTextArea 
                                id="dispositivo_observaciones"
                                label="Observaciones"
                                value={data.observaciones}
                                onChange={e => setData('observaciones', e.target.value)}
                                error={errors.observaciones}
                            />
                        </div>
                    </div>
                )}
            </div>
        );
    };

    const renderActiveSection = () => {
        switch (activeSection) {
            case 'signos':
                return <SignosVitalesForm 
                    hoja={hojaenfermeria}/>;
            case 'medicamentos':
                return <MedicamentosForm 
                        hoja={hojaenfermeria}
                        medicamentos={medicamentos}/>;
            case 'terapia_iv':
                return <TerapiaIVForm
                        hoja={hojaenfermeria}
                        soluciones={soluciones}/>;
            //case 'estudios':
            case 'sondas':
                return <SondasCateteres/>
            case 'liquidos':
                return <div><p>Campos para Control de Líquidos...</p></div>;
            case 'dieta':
                return <div><p>Campos para Dieta...</p></div>;
            case 'graficas':
                return <GraficaContent
                        historialSignos={dataParaGraficas ?? []}/>
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
            <div className="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 mt-6 p-6">
                <NavigationTabs />
                
                <div className="mt-4">
                    {renderActiveSection()}
                </div>
            </div>
        </>
    );
}

Create.layout = (page: React.ReactElement) => {
    return (
        <MainLayout pageTitle='Creación de hoja de enfermería' children={page} />
    );
}

export default Create;