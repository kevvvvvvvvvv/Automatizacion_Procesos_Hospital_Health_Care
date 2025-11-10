import React, { useMemo, useState } from 'react';
import { useForm } from '@inertiajs/react';
import { Estancia, CatalogoEstudio, SolicitudEstudio, User } from '@/types';
import { route } from 'ziggy-js';

import InputTextArea from '@/components/ui/input-text-area';
import PrimaryButton from '@/components/ui/primary-button';
import Checkbox from '@/components/ui/input-checkbox';
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select';

interface Props {
    estancia: Estancia;
    catalogoEstudios: CatalogoEstudio[]; 
    solicitudesAnteriores: SolicitudEstudio[];
    medicos: User[];
}

interface PropsPatologia{
    estancia: Estancia;
    medicos: User[];
}

const optionsEstudios = [
    { value: 'LABORATORIO', label: 'Laboratorio'},
    { value: 'RAYOS X', label: 'Rayos X'},
    { value: 'ELECTROCARDIOGRAMA', label: 'Electrocardiograma'},
    { value: 'ULTRASONIDO', label: 'Ultrasonido'},
    { value: 'TOMOGRAFIA', label: 'Tomografía'},
    { value: 'RESONANCIA', label: 'Resonancia'},
];

const FormularioPatologia: React.FC<PropsPatologia> = ({ estancia, medicos }) => {
    
    const { data, setData, post, processing, errors } = useForm({
        user_solicita_id: '',
        estudio_solicitado: '',
        biopsia_pieza_quirurgica: '',
        revision_laminillas: '',
        estudios_especiales: '',
        pcr: '',
        pieza_remitida: '',
        datos_clinicos: '',
    });

    const optionsMedico = medicos.map(medico => ({
        value: medico.id.toString(),
        label: `${medico.nombre} ${medico.apellido_paterno} ${medico.apellido_materno}`
    }))

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('solicitudes-patologias.store', { estancia: estancia.id }), {
            preserveScroll: true,
        });
    }

    return (
        <form onSubmit={handleSubmit} >
            <div className="space-y-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                <InputText
                    id='estudio_solicitado'
                    name = 'estudio_solicitado'
                    label="Estudio solicitado"
                    value={data.estudio_solicitado}
                    onChange={e => setData('estudio_solicitado', e.target.value)}
                    error={errors.estudio_solicitado}
                />
                <InputText
                    id='biopsia_pieza'
                    name = 'biopsia_pieza'
                    label="Biopsia o pieza quirúrgica"
                    value={data.biopsia_pieza_quirurgica}
                    onChange={e => setData('biopsia_pieza_quirurgica', e.target.value)}
                    error={errors.biopsia_pieza_quirurgica}
                />
                <InputText
                    id='laminillas'
                    name = 'laminillas'
                    label="Revisión de laminillas"
                    value={data.revision_laminillas}
                    onChange={e => setData('revision_laminillas', e.target.value)}
                    error={errors.revision_laminillas}
                />
                <InputText
                    id='estudios_especiales'
                    name = 'estudios_especiales'
                    label="Estudios especiales"
                    value={data.estudios_especiales}
                    onChange={e => setData('estudios_especiales', e.target.value)}
                    error={errors.estudios_especiales}
                />

                <InputText
                    id='pcr'
                    name = 'pcr'
                    label="PCR"
                    value={data.pcr}
                    onChange={e => setData('pcr', e.target.value)}
                    error={errors.pcr}
                />

                <InputText
                    id='pieza_remitida'
                    name = 'pieza_remitida'
                    label="Pieza remitida"
                    value={data.pieza_remitida}
                    onChange={e => setData('pieza_remitida', e.target.value)}
                    error={errors.pieza_remitida}
                />

                <InputTextArea
                    label="Datos clínicos (anotar el número de registro si cuenta con estudio anatomopatólogico previo)"
                    value={data.datos_clinicos}
                    onChange={e => setData('datos_clinicos', e.target.value)}
                    error={errors.datos_clinicos}
                />

                <SelectInput
                    label="Medico que solicita"
                    value={data.user_solicita_id}
                    options={optionsMedico} 
                    onChange={(value) => setData('user_solicita_id', value as string)}
                    error={errors.user_solicita_id} 
                />
            </div>
            <div className="flex justify-end mt-4">
                <PrimaryButton type="submit" disabled={processing || !data.biopsia_pieza_quirurgica || !data.datos_clinicos || !data.estudio_solicitado || !data.estudios_especiales || !data.user_solicita_id || !data.pcr || !data.pieza_remitida || !data.revision_laminillas}>
                    {processing ? 'Guardando...' : 'Guardar solicitud de patología'}
                </PrimaryButton>
            </div>
        </form>
    );
};



const SolicitudEstudiosForm: React.FC<Props> = ({ 
    estancia, 
    catalogoEstudios = [], 
    solicitudesAnteriores = [],
    medicos,
}) => {
    
    const [activeTab, setActiveTab] = useState<'estudios' | 'patologia'>('estudios');

    const [filtro, setFiltro] = useState('');
    const { data, setData, post, processing, errors, reset } = useForm({
        diagnostico_problemas: '',
        incidentes_accidentes: '',
        estudios_agregados_ids: [] as number[],
    });

    const estudiosFiltrados = useMemo(() => {
        if (!filtro) {
            return catalogoEstudios; 
        }
        return catalogoEstudios.filter(estudio =>
            estudio.nombre.toLowerCase().includes(filtro.toLowerCase())
        );
    }, [catalogoEstudios, filtro]);

    const gruposEstudios = useMemo(() => {
        const grupos: { [key: string]: CatalogoEstudio[] } = {};
        optionsEstudios.forEach(opt => grupos[opt.label] = []);


        estudiosFiltrados.forEach(estudio => {
            switch (estudio.tipo_estudio) {
                case 'Laboratorio':
                    grupos['Laboratorio']?.push(estudio);
                    break;
                case 'Cardiología':
                    grupos['Electrocardiograma']?.push(estudio);
                    break;
                case 'Imagenología':
                    if (estudio.departamento === 'Radiología') grupos['Rayos X']?.push(estudio);
                    else if (estudio.departamento === 'Ultrasonido') grupos['Ultrasonido']?.push(estudio);
                    else if (estudio.departamento === 'Tomografía Computada') grupos['Tomografía']?.push(estudio);
                    else if (estudio.departamento === 'Resonancia') grupos['Resonancia']?.push(estudio);
                    break;
            }
        });
        return grupos;
    }, [estudiosFiltrados]); 

    const estudiosSeleccionados = useMemo(() => {
        return catalogoEstudios.filter(estudio => 
            data.estudios_agregados_ids.includes(estudio.id)
        );
    }, [data.estudios_agregados_ids, catalogoEstudios]);

    const handleCheckboxChange = (estudioId: number, isChecked: boolean) => {
        if (isChecked) {
            setData('estudios_agregados_ids', [...data.estudios_agregados_ids, estudioId]);
        } else {
            setData('estudios_agregados_ids', 
                data.estudios_agregados_ids.filter(id => id !== estudioId)
            );
        }
    }

    const handleSubmitEstudios = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('solicitudes-estudios.store', { estancia: estancia.id }), {
            preserveScroll: true,
            onSuccess: () => reset(),
        });
    }

    return (
        <div>
            <div className="border-b border-gray-200 mb-6">
                <nav className="-mb-px flex space-x-6" aria-label="Tabs">
                    <button
                        type="button"
                        onClick={() => setActiveTab('estudios')}
                        className={`py-3 px-1 border-b-2 font-medium text-sm ${
                            activeTab === 'estudios'
                                ? 'border-blue-500 text-blue-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700'
                        }`}
                    >
                        Solicitar Estudios (Lab, Imagen, etc.)
                    </button>
                    <button
                        type="button"
                        onClick={() => setActiveTab('patologia')}
                        className={`py-3 px-1 border-b-2 font-medium text-sm ${
                            activeTab === 'patologia'
                                ? 'border-blue-500 text-blue-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700'
                        }`}
                    >
                        Solicitar Pieza Patológica
                    </button>
                </nav>
            </div>

            {activeTab === 'estudios' && (
                <form onSubmit={handleSubmitEstudios} className="space-y-6">

                    <div className="bg-white p-6 rounded-lg shadow-md">
                        <InputTextArea
                            id="diagnostico_problemas"
                            label="Problemas Clínicos (Diagnóstico)"
                            value={data.diagnostico_problemas}
                            onChange={e => setData('diagnostico_problemas', e.target.value)}
                            error={errors.diagnostico_problemas}
                        />
                        <InputTextArea
                            id="incidentes_accidentes"
                            label="Incidentes y Accidentes Médicos"
                            value={data.incidentes_accidentes}
                            onChange={e => setData('incidentes_accidentes', e.target.value)}
                            error={errors.incidentes_accidentes}
                        />
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-md">
                        <h3 className="text-lg font-semibold">Seleccionar Estudios</h3>
                        

                        <InputText
                            id="filtro_estudios"
                            name="filtro_estudios"
                            label="Buscar estudio por nombre..."
                            value={filtro}
                            onChange={e => setFiltro(e.target.value)}
                        />

                        {optionsEstudios.map(categoria => (
                            <div key={categoria.value} className="mb-4">
                                <h4 className="text-md font-semibold text-blue-700 border-b pb-1 mb-2">
                                    {categoria.label}
                                </h4>
                                <div className="grid grid-cols-2 md:grid-cols-3 gap-2 mt-1 ml-4">
                                    {gruposEstudios[categoria.label]?.length > 0 ? (
                                        gruposEstudios[categoria.label].map(estudio => (
                                            <Checkbox
                                                key={estudio.id}
                                                label={estudio.nombre}
                                                id={`estudio_${estudio.id}`}
                                                checked={data.estudios_agregados_ids.includes(estudio.id)}
                                                onChange={e => handleCheckboxChange(estudio.id, e.target.checked)}
                                            />
                                        ))
                                    ) : (
                                        <p className="text-sm text-gray-400 col-span-full">
                                            {filtro ? 'Ningún estudio coincide con la búsqueda.' : 'No hay estudios definidos.'}
                                        </p>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-md">
                    <h3 className="text-lg font-semibold mb-2">Estudios Seleccionados (Pendientes)</h3>
                    
                    <div className="overflow-x-auto border rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr className='text-left text-xs font-medium text-gray-500 uppercase'>
                                    <th className="px-4 py-3">Estudio</th>
                                    <th className="px-4 py-3">Departamento</th>
                                    <th className="px-4 py-3">Tipo</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {estudiosSeleccionados.length === 0 ? (
                                    <tr>
                                        <td colSpan={3} className="px-4 py-4 text-sm text-gray-500 text-center">
                                            No se han seleccionado estudios.
                                        </td>
                                    </tr>
                                ) : (
                                    estudiosSeleccionados.map((estudio) => (
                                        <tr key={estudio.id}>
                                            <td className="px-4 py-4 text-sm text-gray-900">{estudio.nombre}</td>
                                            <td className="px-4 py-4 text-sm text-gray-500">{estudio.departamento}</td>
                                            <td className="px-4 py-4 text-sm text-gray-500">{estudio.tipo_estudio}</td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
                    
                    <div className="flex justify-end mt-4">
                        <PrimaryButton type="submit" disabled={processing || data.estudios_agregados_ids.length === 0}>
                            {processing ? 'Guardando...' : 'Guardar Solicitud de Estudios'}
                        </PrimaryButton>
                    </div>
                </form>
            )}
            
            {activeTab === 'patologia' && (
                <div className="bg-white p-6 rounded-lg shadow-md">
                    <FormularioPatologia 
                    estancia={estancia}
                    medicos={medicos} />
                </div>
            )}
            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Historial de Solicitudes Anteriores</h3>
                <div className="space-y-4">
                    {(solicitudesAnteriores ?? []).length === 0 ? (
                        <p className="text-sm text-gray-500">No hay solicitudes anteriores para esta estancia.</p>
                    ) : (
                        solicitudesAnteriores.map((solicitud: SolicitudEstudio) => (
                            <div key={solicitud.id} className="bg-white p-4 rounded-lg shadow-sm border">
                                <p className="font-semibold">Solicitud #{solicitud.id} - {new Date(solicitud.created_at).toLocaleString()}</p>
                                <p className="text-sm text-gray-700 mt-1">Problemas Clínicos: {solicitud.problemas_clinicos}</p>
                                <ul className="list-disc pl-5 mt-2 text-sm text-gray-600">
                                    {(solicitud.solicitud_items ?? []).map(item => (
                                        <li key={item.id}>
                                            {item.catalogo_estudio?.nombre} ({item.estado})
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        ))
                    )}
                </div>
            </div>
        </div>
    );
};

export default SolicitudEstudiosForm;