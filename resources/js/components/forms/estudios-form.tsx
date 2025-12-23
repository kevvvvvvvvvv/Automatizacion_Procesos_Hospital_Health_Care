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

interface EstudioManual {
    nombre: string;
    departamento: string;
}

interface EstudioProps {
    estudios: CatalogoEstudio[];
}

const ESTUDIOS_FRECUENTES = [
    'BIOMETRIA HEMATICA',
    'QUIMICA SANGUINEA DE 6 ELEMENTOS',
    'PRUEBAS DE FUNCIONAMIENTO HEPATICO',
    'GRUPO SANGUINEO Y RH',
    'EXAMEN GENERAL DE ORINA',
    'ELECTROLITOS SERICOS',
    'TELE DE TÓRAX',
    'ABDOMEN SUPERIOR',
    'CRÁNEO' 
];
const optionsEstudios = [
    { value: 'Laboratorio', label: 'Laboratorio'},
    { value: 'Rayos X', label: 'Rayos X'},
    { value: 'Electrocardiograma', label: 'Electrocardiograma'},
    { value: 'Ultrasonido', label: 'Ultrasonido'},
    { value: 'Tomografía computada', label: 'Tomografía computada'},
    { value: 'Resonancia magnética', label: 'Resonancia magnética'},
    { value: 'Radiología general', label: 'Radiología general'},
];

// --- COMPONENTE PATOLOGÍA (Igual) ---
const FormularioPatologia: React.FC<PropsPatologia> = ({ estancia, medicos }) => {
    const { data, setData, post, processing, errors } = useForm({
        user_solicita_id: '', estudio_solicitado: '', biopsia_pieza_quirurgica: '', revision_laminillas: '', estudios_especiales: '', pcr: '', pieza_remitida: '', datos_clinicos: '',
    });
    const optionsMedico = medicos.map(medico => ({ value: medico.id.toString(), label: `${medico.nombre} ${medico.apellido_paterno} ${medico.apellido_materno}` }));
    const handleSubmit = (e: React.FormEvent) => { e.preventDefault(); post(route('solicitudes-patologias.store', { estancia: estancia.id }), { preserveScroll: true }); }
    return (
        <form onSubmit={handleSubmit} >
            <div className="space-y-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                <InputText id='estudio_solicitado' name='estudio_solicitado' label="Estudio solicitado" value={data.estudio_solicitado} onChange={e => setData('estudio_solicitado', e.target.value)} error={errors.estudio_solicitado} />
                <InputText id='biopsia_pieza' name='biopsia_pieza' label="Biopsia o pieza quirúrgica" value={data.biopsia_pieza_quirurgica} onChange={e => setData('biopsia_pieza_quirurgica', e.target.value)} error={errors.biopsia_pieza_quirurgica} />
                <InputText id='laminillas' name='laminillas' label="Revisión de laminillas" value={data.revision_laminillas} onChange={e => setData('revision_laminillas', e.target.value)} error={errors.revision_laminillas} />
                <InputText id='estudios_especiales' name='estudios_especiales' label="Estudios especiales" value={data.estudios_especiales} onChange={e => setData('estudios_especiales', e.target.value)} error={errors.estudios_especiales} />
                <InputText id='pcr' name='pcr' label="PCR" value={data.pcr} onChange={e => setData('pcr', e.target.value)} error={errors.pcr} />
                <InputText id='pieza_remitida' name='pieza_remitida' label="Pieza remitida" value={data.pieza_remitida} onChange={e => setData('pieza_remitida', e.target.value)} error={errors.pieza_remitida} />
                <InputTextArea label="Datos clínicos" value={data.datos_clinicos} onChange={e => setData('datos_clinicos', e.target.value)} error={errors.datos_clinicos} />
                <SelectInput label="Medico que solicita" value={data.user_solicita_id} options={optionsMedico} onChange={(value) => setData('user_solicita_id', value as string)} error={errors.user_solicita_id} />
            </div>
            <div className="flex justify-end mt-4">
                <PrimaryButton type="submit" disabled={processing || !data.estudio_solicitado || !data.user_solicita_id || !data.pieza_remitida }>
                    {processing ? 'Guardando...' : 'Guardar solicitud de patología'}
                </PrimaryButton>
            </div>
        </form>
    );
};



// --- COMPONENTE PRINCIPAL ---
const SolicitudEstudiosForm: React.FC<Props> = ({ estancia, catalogoEstudios = [], solicitudesAnteriores = [], medicos }) => {
    
    const [activeTab, setActiveTab] = useState<'estudios' | 'patologia'>('estudios');
    const [filtro, setFiltro] = useState('');
    const [textoNuevoEstudio, setTextoNuevoEstudio] = useState('');
    const [deptoNuevoEstudio, setDeptoNuevoEstudio] = useState('');

    const optionsMedico = medicos.map(medico => ({
        value: medico.id.toString(),
        label: `${medico.nombre} ${medico.apellido_paterno} ${medico.apellido_materno}`
    }))

    const { data, setData, post, processing, errors, reset } = useForm({
        user_solicita_id: '',
        estudios_agregados_ids: [] as number[],
        estudios_adicionales: [] as EstudioManual[],
        detallesEstudios: {} as Record<number, { modalidad?: string, via?: string, especificacion?: string }>
    });

    const estudiosVisibles = useMemo(() => {
        if (filtro.trim() !== '') {
            return catalogoEstudios.filter(estudio => estudio.nombre.toLowerCase().includes(filtro.toLowerCase()));
        }
        return catalogoEstudios.filter(estudio => ESTUDIOS_FRECUENTES.includes(estudio.nombre));
    }, [catalogoEstudios, filtro]);

    const gruposEstudios = useMemo(() => {
        const grupos: { [key: string]: CatalogoEstudio[] } = {};
        optionsEstudios.forEach(opt => grupos[opt.label] = []);

        estudiosVisibles.forEach(estudio => {
            let cat = 'Otros';
            if (estudio.tipo_estudio === 'Laboratorio') cat = 'Laboratorio';
            else if (estudio.tipo_estudio === 'Cardiología') cat = 'Electrocardiograma';
            else if (estudio.departamento === 'Radiología') cat = 'Rayos X'; 
            else if (estudio.departamento === 'Ultrasonido') cat = 'Ultrasonido';
            else if (estudio.departamento === 'Tomografía computada') cat = 'Tomografía computada';
            else if (estudio.departamento === 'Resonancia magnética') cat = 'Resonancia magnética';
            else if (estudio.departamento === 'Radiología general') cat = 'Radiología general';
            
            if (grupos[cat]) grupos[cat].push(estudio);
        });
        return grupos;
    }, [estudiosVisibles]);

    const estudiosSeleccionados = useMemo(() => {
        return catalogoEstudios.filter(estudio => data.estudios_agregados_ids.includes(estudio.id));
    }, [data.estudios_agregados_ids, catalogoEstudios]);

    const handleCheckboxChange = (estudioId: number, isChecked: boolean, nombreDepartamento: string) => {
        const nuevosIds = isChecked
            ? [...data.estudios_agregados_ids, estudioId]
            : data.estudios_agregados_ids.filter(id => id !== estudioId);

        const nuevosDetalles = { ...data.detallesEstudios };

        if (isChecked) {
            // Inicializar en "Simple" por defecto
            if (nombreDepartamento === 'Tomografía computada' || nombreDepartamento === 'Resonancia magnética') {
                nuevosDetalles[estudioId] = { modalidad: 'Simple', via: '' };
            }
        } else {
            delete nuevosDetalles[estudioId];
        }

        setData({ ...data, estudios_agregados_ids: nuevosIds, detallesEstudios: nuevosDetalles });
    };

    const handleDetalleChange = (estudioId: number, campo: string, valor: string) => {
        const nuevosDetalles = { ...data.detallesEstudios, [estudioId]: { ...data.detallesEstudios[estudioId], [campo]: valor }};
        setData('detallesEstudios', nuevosDetalles);
    };

    const handleAddCustomEstudio = () => {
        if (!textoNuevoEstudio.trim()) return;
        if (!deptoNuevoEstudio) { alert("Selecciona un departamento."); return; }
        const nuevoManual = { nombre: textoNuevoEstudio.trim(), departamento: deptoNuevoEstudio };
        setData('estudios_adicionales', [...data.estudios_adicionales, nuevoManual]);
        setTextoNuevoEstudio('');
        setDeptoNuevoEstudio('');
    };

    const handleRemoveCustomEstudio = (index: number) => {
        setData('estudios_adicionales', data.estudios_adicionales.filter((_, i) => i !== index));
    };

    const handleSubmitEstudios = (e: React.FormEvent) => {
        e.preventDefault();
        const estudiosEstructurados = data.estudios_agregados_ids.map(id => ({
            id: id,
            detalles: data.detallesEstudios[id] || null
        }));

        post(route('estancia.solicitudes-estudios.store', { estancia: estancia.id }), {
            data: { ...data, estudios_estructurados: estudiosEstructurados },
            preserveScroll: true,
            onSuccess: () => { reset(); setFiltro(''); },
        });
    }

    return (
        <div>
            <div className="border-b border-gray-200 mb-6">
                <nav className="-mb-px flex space-x-6">
                    <button type="button" onClick={() => setActiveTab('estudios')} className={`py-3 px-1 border-b-2 font-medium text-sm ${activeTab === 'estudios' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'}`}>Solicitar estudios</button>
                    <button type="button" onClick={() => setActiveTab('patologia')} className={`py-3 px-1 border-b-2 font-medium text-sm ${activeTab === 'patologia' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'}`}>Solicitar patología</button>
                </nav>
            </div>

            {activeTab === 'estudios' && (
                <form onSubmit={handleSubmitEstudios} className="space-y-6">
                    <div className="bg-white p-6 rounded-lg shadow-md">
                        <SelectInput value={data.user_solicita_id} label="Médico" options={optionsMedico} onChange={e => setData('user_solicita_id', e)} error={errors.user_solicita_id} />
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-md">
                        <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <div>
                                <h3 className="text-lg font-semibold text-gray-800">Selección de Estudios</h3>
                                <p className="text-sm text-gray-500">{filtro ? 'Mostrando resultados de la búsqueda:' : 'Mostrando estudios frecuentes.'}</p>
                            </div>
                            <div className="w-full md:w-1/3">
                                <InputText id="filtro" name="filtro" value={filtro} onChange={(e) => setFiltro(e.target.value)} placeholder="🔍 Buscar estudio..." />
                            </div>
                        </div>

                        <div className="space-y-6">
                            {optionsEstudios.map(categoria => {
                                const listaEstudios = gruposEstudios[categoria.label] || [];
                                if (listaEstudios.length === 0) return null;

                                return (
                                    <div key={categoria.value} className="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 className="text-md font-bold text-blue-800 border-b border-gray-200 pb-2 mb-3">{categoria.label}</h4>
                                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                            {listaEstudios.map(estudio => {
                                                const isChecked = data.estudios_agregados_ids.includes(estudio.id);
                                                const esEspecial = categoria.label === 'Tomografía computada' || categoria.label === 'Resonancia magnética';

                                                return (
                                                    <div key={estudio.id} className={`p-3 rounded-lg border transition-all ${isChecked ? 'bg-white border-blue-400 shadow-md' : 'bg-white/50 border-gray-200'}`}>
                                                        <Checkbox label={estudio.nombre} id={`estudio_${estudio.id}`} checked={isChecked} onChange={e => handleCheckboxChange(estudio.id, e.target.checked, categoria.label)} />
                                                        
                                                        {/* --- AQUÍ ESTÁ EL CAMBIO IMPORTANTE: SELECT EN LUGAR DE RADIOS --- */}
                                                        {isChecked && esEspecial && (
                                                            <div className="mt-3 ml-2 pt-2 border-t border-gray-100 animate-fadeIn space-y-3">
                                                                
                                                                {/* 1. SELECCIONAR MODALIDAD */}
                                                                <div>
                                                                    <label className="block text-xs font-bold text-gray-500 mb-1">Modalidad:</label>
                                                                    <select 
                                                                        className="block w-full text-xs border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 py-1.5"
                                                                        value={data.detallesEstudios[estudio.id]?.modalidad || 'Simple'}
                                                                        onChange={(e) => handleDetalleChange(estudio.id, 'modalidad', e.target.value)}
                                                                    >
                                                                        <option value="Simple">Simple</option>
                                                                        <option value="Contrastada">Contrastada</option>
                                                                    </select>
                                                                </div>

                                                                {/* 2. SI ES CONTRASTADA, MOSTRAR VÍA (SI ES SIMPLE, NO SE MUESTRA NADA MÁS) */}
                                                                {data.detallesEstudios[estudio.id]?.modalidad === 'Contrastada' && (
                                                                    <div>
                                                                        <label className="block text-xs font-bold text-blue-600 mb-1">Vía de administración:</label>
                                                                        <select 
                                                                            className="block w-full text-xs border-blue-300 rounded focus:ring-blue-500 focus:border-blue-500 py-1.5 bg-blue-50"
                                                                            value={data.detallesEstudios[estudio.id]?.via || ''}
                                                                            onChange={(e) => handleDetalleChange(estudio.id, 'via', e.target.value)}
                                                                        >
                                                                            <option value="">-- Seleccionar Vía --</option>
                                                                            <option value="Venosa">Venosa (IV)</option>
                                                                            <option value="Oral">Oral</option>
                                                                            <option value="Otra">Otra</option>
                                                                        </select>
                                                                        {data.detallesEstudios[estudio.id]?.via === 'Otra' && (
                                                                            <input type="text" className="mt-2 block w-full text-xs border-gray-300 rounded focus:ring-blue-500" placeholder="Especifique..." value={data.detallesEstudios[estudio.id]?.especificacion || ''} onChange={(e) => handleDetalleChange(estudio.id, 'especificacion', e.target.value)} />
                                                                        )}
                                                                    </div>
                                                                )}
                                                            </div>
                                                        )}
                                                    </div>
                                                );
                                            })}
                                        </div>
                                    </div>
                                );
                            })}
                            
                            {Object.keys(gruposEstudios).every(k => gruposEstudios[k].length === 0) && (
                                <div className="text-center py-8 bg-gray-50 rounded border border-dashed border-gray-300">
                                    <p className="text-gray-500">No se encontraron estudios con el nombre "{filtro}".</p>
                                </div>
                            )}
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-400">
                        <h3 className="text-lg font-semibold mb-2">Estudio Manual</h3>
                        <div className="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-yellow-50 p-4 rounded-lg">
                            <div className="md:col-span-6"><InputText id="nuevo_estudio_manual" name="nuevo_estudio_manual" label="Nombre" value={textoNuevoEstudio} onChange={e => setTextoNuevoEstudio(e.target.value)} /></div>
                            <div className="md:col-span-4"><SelectInput label='Departamento' options={optionsEstudios} value={deptoNuevoEstudio} onChange={e => setDeptoNuevoEstudio(e)} /></div>
                            <div className="md:col-span-2"><button type="button" onClick={handleAddCustomEstudio} className="w-full h-10 bg-gray-800 text-white text-sm font-medium rounded-md shadow">Agregar</button></div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500 mt-6">
                        <h3 className="text-lg font-semibold mb-2 text-gray-800">Estudios seleccionados (pendientes)</h3>
                        <div className="overflow-x-auto border rounded-lg">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr className='text-left text-xs font-medium text-gray-500 uppercase'>
                                        <th className="px-4 py-3">Estudio</th>
                                        <th className="px-4 py-3">Departamento</th>
                                        <th className="px-4 py-3">Tipo</th>
                                        <th className="px-4 py-3 text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {estudiosSeleccionados.map((estudio) => (
                                        <tr key={estudio.id}>
                                            <td className="px-4 py-4 text-sm text-gray-900 font-medium">
                                                {estudio.nombre}
                                                {/* Mostrar detalles en el resumen para verificar */}
                                                {data.detallesEstudios[estudio.id]?.modalidad === 'Contrastada' ? (
                                                    <span className="ml-2 text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded font-bold">
                                                        (Contrastada - {data.detallesEstudios[estudio.id]?.via})
                                                    </span>
                                                ) : (
                                                    // Solo mostrar (Simple) si es de los departamentos especiales
                                                    (estudio.departamento === 'Tomografía computada' || estudio.departamento === 'Resonancia magnética') && (
                                                        <span className="ml-2 text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">(Simple)</span>
                                                    )
                                                )}
                                            </td>
                                            <td className="px-4 py-4 text-sm text-gray-500">{estudio.departamento}</td>
                                            <td className="px-4 py-4 text-sm text-gray-500"><span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Catálogo</span></td>
                                            <td className="px-4 py-4 text-right"><button type="button" onClick={() => handleCheckboxChange(estudio.id, false, '')} className="text-red-600 hover:text-red-900 text-sm font-bold">Quitar</button></td>
                                        </tr>
                                    ))}
                                    {data.estudios_adicionales.map((item, idx) => (
                                        <tr key={`manual-${idx}`}>
                                            <td className="px-4 py-4 text-sm text-gray-900">{item.nombre}</td>
                                            <td className="px-4 py-4 text-sm text-gray-500">{item.departamento}</td>
                                            <td className="px-4 py-4 text-sm text-gray-500"><span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Manual</span></td>
                                            <td className="px-4 py-4 text-right"><button type="button" onClick={() => handleRemoveCustomEstudio(idx)} className="text-red-600 hover:text-red-900 text-sm font-bold">Quitar</button></td>
                                        </tr>
                                    ))}
                                    {estudiosSeleccionados.length === 0 && data.estudios_adicionales.length === 0 && (
                                        <tr><td colSpan={4} className="px-4 py-6 text-sm text-gray-500 text-center italic">No se han seleccionado estudios aún.</td></tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                                        
                    <div className="flex justify-end mt-4">
                        <PrimaryButton type="submit" disabled={processing || (data.estudios_agregados_ids.length === 0 && data.estudios_adicionales.length === 0)}>{processing ? 'Guardando...' : 'Confirmar Solicitud'}</PrimaryButton>
                    </div>
                </form>
            )}

            {activeTab === 'patologia' && <div className="bg-white p-6 rounded-lg shadow-md"><FormularioPatologia estancia={estancia} medicos={medicos} /></div>}
            
            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Historial de solicitudes anteriores</h3>
                <div className="space-y-4">
                    {(solicitudesAnteriores ?? []).map((solicitud: SolicitudEstudio) => (
                        <div key={solicitud.id} className="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
                             <p className="font-bold text-gray-800">Solicitud #{solicitud.id} <span className="text-xs font-normal text-gray-500">({new Date(solicitud.created_at).toLocaleString()})</span></p>
                             <ul className="list-disc pl-5 mt-1 text-sm text-gray-700">{(solicitud.solicitud_items ?? []).map(item => <li key={item.id}>{item.catalogo_estudio?.nombre || item.otro_estudio}</li>)}</ul>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default SolicitudEstudiosForm;