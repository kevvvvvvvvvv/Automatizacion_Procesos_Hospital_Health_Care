import React, { useState } from 'react'; 
import { Paciente, Estancia, ProductoServicio, HojaEnfermeria, HojaSignosGraficas } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import PacienteCard from '@/components/paciente-card';
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; 
import InputDateTime from '@/components/ui/input-date-time';
import InputTextArea from '@/components/ui/input-text-area';
import TerapiaIVForm from '@/components/terapia-iv-form';
import SignosVitalesForm from '@/components/signos-vitales-form';
import GraficaContent from '@/components/graphs/grafica-content'

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

    const medicamentosOptions = medicamentos.map(m => ({
        value: m.id,
        label: m.nombre_prestacion
    }))

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

    const MedicamentosContent = () => {

        const handleMedicamentoChange = (value: string) => {
           const selected = medicamentosOptions.find(opt => opt.value === Number(value));

            setData(data => ({
                ...data,
                medicamento_id: value,
                medicamento_nombre: selected ? selected.label : ''
            }));
        }

        const handleViaChange = (value: string) => {
            const selected = opcionesViaMedicamento.find(opt => opt.value == value);
            
            setData(data => ({
                ...data,
                medicamento_via: value,
                medicamento_via_label: selected ? selected.label : ''
            }));
        }

        const handleAddMedicamento = (e: React.MouseEvent<HTMLButtonElement>) => {
            e.preventDefault(); 
            if (!data.medicamento_id || !data.medicamento_dosis) {
                alert("Debes seleccionar un medicamento y una dosis.");
                return;
            }

            const newMed: MedicamentoAgregado = {
                id: data.medicamento_id,
                nombre: data.medicamento_nombre,
                dosis: data.medicamento_dosis,
                via_id: data.medicamento_via,
                via_label: data.medicamento_via_label,
                duracion: data.medicamento_duracion_tratamiento,
                inicio: data.medicamento_fecha_hora_inicio,
                temp_id: crypto.randomUUID(),
            };

            setData(currentData => ({
                ...currentData,
                medicamentos_agregados: [...currentData.medicamentos_agregados, newMed],

                medicamento_id: '',
                medicamento_nombre: '',
                medicamento_dosis: '',
                medicamento_via: '',
                medicamento_via_label: '',
                medicamento_duracion_tratamiento: '',
                medicamento_fecha_hora_inicio: '',
            }));
        }

        const handleRemoveMedicamento = (temp_id: string) => {
            const updatedList = data.medicamentos_agregados.filter(
                (med) => med.temp_id !== temp_id
            );
            setData(currentData => ({
                ...currentData,
                medicamentos_agregados: updatedList
            }));
        }

        return (
            <div>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <SelectInput
                        label="Medicamento"
                        options={medicamentosOptions} 
                        value={data.medicamento_id}
                        onChange={(value) => handleMedicamentoChange(value as string)}
                        error={errors.medicamento_id || errors.medicamentos_agregados}
                    />

                    <InputText 
                        id="medicamento_dosis"
                        name="medicamento_dosis"
                        label="Dosis" 
                        type="number"
                        value={data.medicamento_dosis} 
                        onChange={e => setData('medicamento_dosis', e.target.value)} 
                        error={errors.medicamento_dosis}
                    />
                    
                    <SelectInput
                        label="Vía de administración"
                        options={opcionesViaMedicamento}
                        value={data.medicamento_via}
                        onChange={(value) => handleViaChange(value as string)}
                        error={errors.medicamento_via}
                    />

                    <InputText 
                        id="medicamento_duracion_tratamiento"
                        name="medicamento_duracion_tratamiento"
                        label="Duración del tratamiento (horas)" 
                        type="number"
                        value={data.medicamento_duracion_tratamiento}
                        onChange={e => setData('medicamento_duracion_tratamiento', e.target.value)} 
                        error={errors.medicamento_duracion_tratamiento}
                    />

                    <InputDateTime
                        id="medicamento_fecha_hora_inicio"
                        name="medicamento_fecha_hora_inicio"
                        label="Fecha y hora de inicio" 
                        value={data.medicamento_fecha_hora_inicio}
                        onChange={value => setData('medicamento_fecha_hora_inicio', value as string)} 
                        error={errors.medicamento_fecha_hora_inicio}
                    />
                </div>
                <div className="flex justify-end mt-4">
                    <button
                        type="button"
                        onClick={handleAddMedicamento}
                        className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                    >
                        Agregar Medicamento
                    </button>
                </div>

                <div className="mt-8">
                    <h3 className="text-lg font-semibold mb-2">Medicamentos Agregados</h3>
                    <div className="overflow-x-auto border rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Medicamento</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dosis</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vía</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Inicio</th>
                                    <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acción</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {data.medicamentos_agregados.length === 0 ? (
                                    <tr>
                                        <td colSpan={5} className="px-4 py-4 text-sm text-gray-500 text-center">
                                            Aún no se han agregado medicamentos.
                                        </td>
                                    </tr>
                                ) : (
                                    data.medicamentos_agregados.map((med) => (
                                        <tr key={med.temp_id}>
                                            <td className="px-4 py-4 text-sm text-gray-900">{med.nombre}</td>
                                            <td className="px-4 py-4 text-sm text-gray-500">{med.dosis}</td>
                                            <td className="px-4 py-4 text-sm text-gray-500">{med.via_label}</td>
                                            <td className="px-4 py-4 text-sm text-gray-500">{med.inicio}</td>
                                            <td className="px-4 py-4 text-sm">
                                                <button
                                                    type="button"
                                                    onClick={() => handleRemoveMedicamento(med.temp_id)}
                                                    className="text-red-600 hover:text-red-900"
                                                >
                                                    Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        );
    };

    
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
                return <MedicamentosContent />;
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