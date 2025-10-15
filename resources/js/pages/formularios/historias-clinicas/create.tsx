import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React, { useMemo } from 'react'; 
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente } from '@/types';

// --- INTERFACES ---
interface CampoAdicional {
    name: string;
    label: string;
    type: 'text' | 'select' | 'date' | 'number' | 'date_unknown';
    options?: string[];
    dependsOn?: string;
    dependsValue?: string;
}

interface Pregunta {
    id: number;
    pregunta: string;
    categoria: string;
    tipo_pregunta: 'simple' | 'multiple_campos' | 'repetible' | 'direct_select' | 'direct_multiple';
    campos_adicionales: any; // Se define como 'any' para aceptar el string que llega por error
    permite_desconozco: boolean;
}

interface RespuestaDetalles {
    respuesta: 'si' | 'no' | 'desconozco' | '';
    campos?: { [key: string]: string | number | boolean };
    items?: { [key: string]: string | number | boolean }[];
}

interface FormData {
    padecimiento_actual: string;
    tension_arterial: string;
    frecuencia_cardiaca: number | string;
    frecuencia_respiratoria: number | string;
    temperatura: number | string;
    peso: number | string;
    talla: number | string;
    resultados_previos: string;
    diagnostico: string;
    pronostico: string;
    indicacion_terapeutica: string;
    respuestas: {
        [preguntaId: number]: RespuestaDetalles;
    };
}

interface CreateProps {
    preguntas: Pregunta[];
    paciente: Paciente;
    estancia: Estancia;
}

type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const Create: CreateComponent = ({ preguntas, paciente, estancia }) => {

    const { data, setData, post, processing, errors } = useForm<FormData>({
        // ... (otros campos)
        padecimiento_actual: '',
        tension_arterial: '',
        frecuencia_cardiaca: '',
        frecuencia_respiratoria: '',
        temperatura: '',
        peso: '',
        talla: '',
        resultados_previos: '',
        diagnostico: '',
        pronostico: '',
        indicacion_terapeutica: '',
        respuestas: preguntas.reduce((acc, p) => {
            acc[p.id] = { respuesta: '', items: [], campos: {} };
            return acc;
        }, {} as { [key: number]: RespuestaDetalles }),
    });

    const preguntasPorCategoria = useMemo(() => {
        return preguntas.reduce((acc, pregunta) => {
            (acc[pregunta.categoria] = acc[pregunta.categoria] || []).push(pregunta);
            return acc;
        }, {} as Record<string, Pregunta[]>);
    }, [preguntas]);
    
    // --- Manejadores de estado (Sin cambios, ya son correctos) ---
    const handleRespuestaChange = (preguntaId: number, field: string, value: string | number | boolean, itemIndex: number | null = null) => {
        const pregunta = preguntas.find(p => p.id === preguntaId);
        if (!pregunta) return;
        
        setData(prevData => {
            const newRespuestas = { ...prevData.respuestas };
            const newRespuestaActual = { ...newRespuestas[preguntaId] };

            if (field === 'respuesta') {
                newRespuestaActual.respuesta = value as RespuestaDetalles['respuesta'];
                if (value !== 'si') {
                    newRespuestaActual.campos = {};
                    newRespuestaActual.items = [];
                }
            } else {
                if (pregunta.tipo_pregunta === 'repetible' && itemIndex !== null) {
                    const newItems = [...(newRespuestaActual.items || [])];
                    newItems[itemIndex] = { ...newItems[itemIndex], [field]: value };
                    newRespuestaActual.items = newItems;
                } else {
                    newRespuestaActual.campos = { ...(newRespuestaActual.campos || {}), [field]: value };
                }
            }
            newRespuestas[preguntaId] = newRespuestaActual;
            return { ...prevData, respuestas: newRespuestas };
        });
    };

    const addItem = (preguntaId: number) => {
        setData(prev => ({ ...prev, respuestas: { ...prev.respuestas, [preguntaId]: { ...prev.respuestas[preguntaId], items: [...(prev.respuestas[preguntaId].items || []), {}] } } }));
    };

    const removeItem = (preguntaId: number, itemIndex: number) => {
        setData(prev => ({ ...prev, respuestas: { ...prev.respuestas, [preguntaId]: { ...prev.respuestas[preguntaId], items: (prev.respuestas[preguntaId].items || []).filter((_, index) => index !== itemIndex) } } }));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('pacientes.estancias.historiasclinicas.store', { paciente: paciente.id, estancia: estancia.id }));
    };

    const formatarTituloCategoria = (categoria: string) => {
        return categoria.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    };

    const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;
    const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;
    
    // ✅ --- LA SOLUCIÓN DEFINITIVA ESTÁ AQUÍ ---
    const renderPregunta = (pregunta: Pregunta) => {
        const respuestaActual = data.respuestas[pregunta.id];
        if (!respuestaActual) return null;

        // Esta función auxiliar asegura que siempre trabajemos con un array.
        const getCamposAsArray = (campos: any): CampoAdicional[] => {
            if (Array.isArray(campos)) {
                return campos; // Si ya es un array, lo devuelve.
            }
            if (typeof campos === 'string' && campos.startsWith('[')) {
                try {
                    // Si es un string que parece un array JSON, intenta convertirlo.
                    const parsed = JSON.parse(campos);
                    return Array.isArray(parsed) ? parsed : [];
                } catch (e) {
                    return []; // Si la conversión falla, devuelve un array vacío.
                }
            }
            return []; // Para cualquier otra cosa (null, undefined, etc.), devuelve un array vacío.
        };

        // Usamos la función auxiliar para obtener una versión segura de los datos.
        const camposAdicionalesArray = getCamposAsArray(pregunta.campos_adicionales);

        const renderCampo = (campo: CampoAdicional, preguntaId: number, itemIndex: number | null = null) => {
            const isRepetible = itemIndex !== null;
            const value = isRepetible ? respuestaActual.items?.[itemIndex!]?.[campo.name] || '' : respuestaActual.campos?.[campo.name] || '';

            if (campo.dependsOn) {
                const dependenciaValue = isRepetible ? respuestaActual.items?.[itemIndex!]?.[campo.dependsOn] : respuestaActual.campos?.[campo.dependsOn];
                if (dependenciaValue !== campo.dependsValue) return null;
            }
            
            switch (campo.type) {
                // ... (el switch se queda igual)
                case 'select':
                    return (
                        <div key={campo.name}>
                            <label className={labelClasses}>{campo.label}</label>
                            <select value={String(value)} onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.value, itemIndex)} className={`${textAreaClasses} border-gray-600`}>
                                <option value="" disabled>Seleccione...</option>
                                {campo.options?.map(opt => <option key={opt} value={opt}>{opt}</option>)}
                            </select>
                        </div>
                    );
                case 'date_unknown':
                    return (
                        <div key={campo.name}>
                            <label className={labelClasses}>{campo.label}</label>
                            <div className="flex items-center space-x-2">
                                <input type="date" value={value === 'desconocido' ? '' : String(value)} disabled={value === 'desconocido'} onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.value, itemIndex)} className={`${textAreaClasses} border-gray-600`} />
                                <input type="checkbox" id={`${preguntaId}-${campo.name}-unknown`} checked={value === 'desconocido'} onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.checked ? 'desconocido' : '', itemIndex)} />
                                <label htmlFor={`${preguntaId}-${campo.name}-unknown`}>Desconozco</label>
                            </div>
                        </div>
                    );
                default:
                    return (
                        <InputText key={campo.name} id={`${preguntaId}-${isRepetible ? itemIndex + '-' : ''}${campo.name}`} name={campo.name} label={campo.label} type={campo.type} value={String(value)} onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.value, itemIndex)} />
                    );
            }
        };

        if (pregunta.tipo_pregunta === 'direct_select' || pregunta.tipo_pregunta === 'direct_multiple') {
            return (
                <div key={pregunta.id} className="col-span-full md:col-span-1 border p-4 rounded-md shadow-sm">
                    <h3 className="font-semibold text-gray-800 mb-2">{pregunta.pregunta}</h3>
                    {/* Usamos la variable segura */}
                    {camposAdicionalesArray.map(campo => renderCampo(campo, pregunta.id))}
                </div>
            )
        }

        return (
            <div key={pregunta.id} className="col-span-full md:col-span-1 border p-4 rounded-md shadow-sm">
                <label className={labelClasses}>{pregunta.pregunta}</label>
                <select value={respuestaActual.respuesta || ''} onChange={e => handleRespuestaChange(pregunta.id, 'respuesta', e.target.value)} className={`${textAreaClasses} border-gray-600 mb-2`}>
                    <option value="" disabled>Seleccione...</option>
                    <option value="si">Sí</option>
                    <option value="no">No</option>
                    {pregunta.permite_desconozco && <option value="desconozco">Desconozco</option>}
                </select>
                {respuestaActual.respuesta === 'si' && (
                    <div className="pl-4 border-l-2 border-gray-200 space-y-3 mt-3">
                        {pregunta.tipo_pregunta === 'simple' && (
                            <InputText id={`detalle_${pregunta.id}`} name="detalle" label="Especifique" placeholder="Añada detalles aquí..." value={String(respuestaActual.campos?.detalle || '')} onChange={e => handleRespuestaChange(pregunta.id, 'detalle', e.target.value)} />
                        )}
                        {/* Usamos la variable segura */}
                        {pregunta.tipo_pregunta === 'multiple_campos' && camposAdicionalesArray.map(campo => renderCampo(campo, pregunta.id))}
                        {pregunta.tipo_pregunta === 'repetible' && (
                            <div>
                                {respuestaActual.items?.map((_, index) => (
                                    <div key={index} className="border p-2 rounded-md mb-2 relative">
                                        <button type="button" onClick={() => removeItem(pregunta.id, index)} className="absolute top-1 right-1 text-red-500 font-bold">X</button>
                                        {/* Usamos la variable segura */}
                                        {camposAdicionalesArray.map(campo => renderCampo(campo, pregunta.id, index))}
                                    </div>
                                ))}
                                <button type="button" onClick={() => addItem(pregunta.id)} className="text-sm text-blue-600 hover:underline mt-2">+ Añadir otro</button>
                            </div>
                        )}
                    </div>
                )}
            </div>
        );
    };

    return(
        <FormLayout
            title="Registrar Nueva Historia Clínica"
            onSubmit={handleSubmit}
            actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Guardando...' : 'Guardar'}</PrimaryButton>}
        >
            {/* ... El resto de tu JSX ... */}
            <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Signos Vitales y Padecimiento</h2><div className="col-span-full"><label htmlFor="padecimiento_actual" className={labelClasses}>Padecimiento Actual (Indagar acerca de tratamientos previos)</label><textarea id="padecimiento_actual" name="padecimiento_actual" value={data.padecimiento_actual} onChange={(e) => setData('padecimiento_actual', e.target.value)} rows={4} className={`${textAreaClasses} ${errors.padecimiento_actual ? 'border-red-500' : 'border-gray-600'}`} />{errors.padecimiento_actual && <p className="mt-1 text-xs text-red-500">{errors.padecimiento_actual}</p>}</div><InputText id="tension_arterial" name="tension_arterial" label="Tensión Arterial" value={data.tension_arterial} onChange={(e) => setData('tension_arterial', e.target.value)} error={errors.tension_arterial} /><InputText id="frecuencia_cardiaca" name="frecuencia_cardiaca" label="Frecuencia Cardíaca (x min)" type="number" value={String(data.frecuencia_cardiaca)} onChange={(e) => setData('frecuencia_cardiaca', e.target.value)} error={errors.frecuencia_cardiaca} /><InputText id="frecuencia_respiratoria" name="frecuencia_respiratoria" label="Frecuencia Respiratoria (x min)" type="number" value={String(data.frecuencia_respiratoria)} onChange={(e) => setData('frecuencia_respiratoria', e.target.value)} error={errors.frecuencia_respiratoria} /><InputText id="temperatura" name="temperatura" label="Temperatura (°C)" type="number" value={String(data.temperatura)} onChange={(e) => setData('temperatura', e.target.value)} error={errors.temperatura} /><InputText id="peso" name="peso" label="Peso (kg)" type="number" value={String(data.peso)} onChange={(e) => setData('peso', e.target.value)} error={errors.peso} /><InputText id="talla" name="talla" label="Talla (cm)" type="number" value={String(data.talla)} onChange={(e) => setData('talla', e.target.value)} error={errors.talla} />
            {Object.entries(preguntasPorCategoria).map(([categoria, listaPreguntas]) => (
                <div key={categoria} className="col-span-full mt-6">
                    <h2 className="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">{formatarTituloCategoria(categoria)}</h2>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {listaPreguntas.map(pregunta => renderPregunta(pregunta))}
                    </div>
                </div>
            ))}
            <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Análisis, Diagnóstico y Plan</h2><div className="col-span-full"><label htmlFor="resultados_previos" className={labelClasses}>Resultados Previos y Actuales de Laboratorio y Gabinete</label><textarea id="resultados_previos" name="resultados_previos" value={data.resultados_previos} onChange={e => setData('resultados_previos', e.target.value)} rows={4} className={`${textAreaClasses} ${errors.resultados_previos ? 'border-red-500' : 'border-gray-600'}`} />{errors.resultados_previos && <p className="mt-1 text-xs text-red-500">{errors.resultados_previos}</p>}</div><div className="col-span-full"><label htmlFor="diagnostico" className={labelClasses}>Diagnóstico(s)</label><textarea id="diagnostico" name="diagnostico" value={data.diagnostico} onChange={e => setData('diagnostico', e.target.value)} rows={4} className={`${textAreaClasses} ${errors.diagnostico ? 'border-red-500' : 'border-gray-600'}`} />{errors.diagnostico && <p className="mt-1 text-xs text-red-500">{errors.diagnostico}</p>}</div><div className="col-span-full"><label htmlFor="pronostico" className={labelClasses}>Pronóstico</label><textarea id="pronostico" name="pronostico" value={data.pronostico} onChange={e => setData('pronostico', e.target.value)} rows={2} className={`${textAreaClasses} ${errors.pronostico ? 'border-red-500' : 'border-gray-600'}`} />{errors.pronostico && <p className="mt-1 text-xs text-red-500">{errors.pronostico}</p>}</div><div className="col-span-full"><label htmlFor="indicacion_terapeutica" className={labelClasses}>Indicación Terapéutica</label><textarea id="indicacion_terapeutica" name="indicacion_terapeutica" value={data.indicacion_terapeutica} onChange={e => setData('indicacion_terapeutica', e.target.value)} rows={4} className={`${textAreaClasses} ${errors.indicacion_terapeutica ? 'border-red-500' : 'border-gray-600'}`} />{errors.indicacion_terapeutica && <p className="mt-1 text-xs text-red-500">{errors.indicacion_terapeutica}</p>}</div>
        </FormLayout>
    );
};

Create.layout = (page: React.ReactElement) => {
    return (
        <MainLayout pageTitle="Creación de Historia Clínica" children={page} />
    );
};

export default Create;