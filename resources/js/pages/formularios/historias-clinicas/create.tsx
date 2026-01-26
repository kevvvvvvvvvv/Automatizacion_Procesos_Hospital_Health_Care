import React, { useMemo } from 'react'; 
import { useForm, usePage, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente } from '@/types';

import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import PacienteCard from '@/components/paciente-card';
import InputTextArea from '@/components/ui/input-text-area';

interface CampoAdicional {
    name: string;
    label: string;
    type: 'text' | 'select' | 'date' | 'number' | 'date_unknown'|'month_unknown';
    options?: string[];
    dependsOn?: string;
    dependsValue?: string;
}

interface OpcionRespuesta {
    value: string;
    label: string;
    triggersFields?: boolean; 
}

interface Pregunta {
    id: number;
    pregunta: string;
    categoria: string;
    tipo_pregunta: 'simple' | 'multiple_campos' | 'repetible' | 'direct_select' | 'direct_multiple' ;
    campos_adicionales: any; 
    permite_desconozco: boolean;
    opciones_respuesta: any;
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
    saturacion_oxigeno: number;
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

    const { errors } = usePage().props;

    const getCamposAsArray = (campos: any): CampoAdicional[] => {
        if (Array.isArray(campos)) return campos;
        if (typeof campos === 'string' && campos.startsWith('[')) {
            try {
                const parsed = JSON.parse(campos);
                return Array.isArray(parsed) ? parsed : [];
            } catch (e) { return []; }
        }
        return [];
    };

    const getOpcionesAsArray = (opciones: any): OpcionRespuesta[] => {
        if (Array.isArray(opciones)) return opciones;
        if (typeof opciones === 'string' && opciones.startsWith('[')) {
            try {
                const parsed = JSON.parse(opciones);
                return Array.isArray(parsed) ? parsed : [];
            } catch (e) { return []; }
        }
        return [];
    };

    const { data, setData, post, processing } = useForm<FormData>({
        padecimiento_actual: '',
        tension_arterial: '',
        frecuencia_cardiaca: '',
        frecuencia_respiratoria: '',
        saturacion_oxigeno: '',
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
    
    const categoriasVisibles = useMemo(() => {
        return Object.entries(preguntasPorCategoria).filter(([categoria]) => {
            if (categoria !== 'gineco_obstetrico') {
                return true;
            }
            return paciente.sexo === 'Femenino';
        });
    }, [preguntasPorCategoria, paciente.sexo]);

    const handleRespuestaChange = (preguntaId: number, field: string, value: string | number | boolean, itemIndex: number | null = null) => {
        const pregunta = preguntas.find(p => p.id === preguntaId);
        if (!pregunta) return;

        const opcionesRespuestaArray = getOpcionesAsArray(pregunta.opciones_respuesta);
        
        setData(prevData => {
            const newRespuestas = { ...prevData.respuestas };
            const newRespuestaActual = { ...newRespuestas[preguntaId] };

            if (field === 'respuesta') {
                newRespuestaActual.respuesta = value as RespuestaDetalles['respuesta'];
                if (value !== 'si' && !opcionesRespuestaArray.find(opt => opt.value === value)?.triggersFields) {
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
    
    const renderPregunta = (pregunta: Pregunta) => {
        const respuestaActual = data.respuestas[pregunta.id];
        if (!respuestaActual) return null;

        const camposAdicionalesArray = getCamposAsArray(pregunta.campos_adicionales);
        const opcionesRespuestaArray = getOpcionesAsArray(pregunta.opciones_respuesta);

        const debeMostrarCampos = () => {
            if (opcionesRespuestaArray.length > 0) {
                const opcionSeleccionada = opcionesRespuestaArray.find(
                    opt => opt.value === respuestaActual.respuesta
                );
                return opcionSeleccionada?.triggersFields === true;
            }
            return respuestaActual.respuesta === 'si';
        };
        
        const renderCampo = (campo: CampoAdicional, preguntaId: number, itemIndex: number | null = null) => {
            const isRepetible = itemIndex !== null;
            const value = isRepetible
                ? respuestaActual.items?.[itemIndex!]?.[campo.name] || ''
                : respuestaActual.campos?.[campo.name] || '';

            if (campo.dependsOn) {
                const dependenciaValue = isRepetible ? respuestaActual.items?.[itemIndex!]?.[campo.dependsOn] : respuestaActual.campos?.[campo.dependsOn];
                if (dependenciaValue !== campo.dependsValue) return null;
            }
            
            switch (campo.type) {
                case 'select':
                    return ( <div key={campo.name}> <label className={labelClasses}>{campo.label}</label> <select value={String(value)} onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.value, itemIndex)} className={`${textAreaClasses} border-gray-600`}> <option value="" disabled>Seleccione...</option> {campo.options?.map(opt => <option key={opt} value={opt}>{opt}</option>)} </select> </div> );
                case 'date_unknown':
                    return ( <div key={campo.name}> <label className={labelClasses}>{campo.label}</label> <div className="flex items-center space-x-2"> <input type="date" value={value === 'desconocido' ? '' : String(value)} disabled={value === 'desconocido'} onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.value, itemIndex)} className={`${textAreaClasses} border-gray-600`} /> <input type="checkbox" id={`${preguntaId}-${campo.name}-unknown`} checked={value === 'desconocido'} onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.checked ? 'desconocido' : '', itemIndex)} /> <label htmlFor={`${preguntaId}-${campo.name}-unknown`}>Desconozco</label> </div> </div> );
                case 'month_unknown':
                    return (
                        <div key={campo.name}>
                            <label className={labelClasses}>{campo.label}</label>
                            <div className="flex items-center space-x-2">
                                <input
                                    type="month"
                                    value={value === 'desconocido' ? '' : String(value).substring(0, 7)}
                                    disabled={value === 'desconocido'}
                                    onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.value, itemIndex)}
                                    className={`${textAreaClasses} border-gray-600`}
                                />
                                <input
                                    type="checkbox"
                                    id={`${preguntaId}-${campo.name}-unknown`}
                                    checked={value === 'desconocido'}
                                    onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.checked ? 'desconocido' : '', itemIndex)}
                                />
                                <label htmlFor={`${preguntaId}-${campo.name}-unknown`}>Desconozco</label>
                            </div>
                        </div>
                    );               
                default:
                    return ( <InputText key={campo.name} id={`${preguntaId}-${isRepetible ? itemIndex + '-' : ''}${campo.name}`} name={campo.name} label={campo.label} type={campo.type} value={String(value)} onChange={e => handleRespuestaChange(preguntaId, campo.name, e.target.value, itemIndex)} /> );
            }
        };

        if (pregunta.tipo_pregunta === 'direct_select' || pregunta.tipo_pregunta === 'direct_multiple') {
            return ( <div key={pregunta.id} className="col-span-full md:col-span-1 border p-4 rounded-md shadow-sm"> <h3 className="font-semibold text-gray-800 mb-2">{pregunta.pregunta}</h3> {camposAdicionalesArray.map(campo => renderCampo(campo, pregunta.id))} </div> )
        }

        return (
            <div key={pregunta.id} className="col-span-full md:col-span-1 border p-4 rounded-md shadow-sm">
                <label className={labelClasses}>{pregunta.pregunta}</label>
                <select 
                    value={respuestaActual.respuesta || ''} 
                    onChange={e => handleRespuestaChange(pregunta.id, 'respuesta', e.target.value)} 
                    className={`${textAreaClasses} border-gray-600 mb-2`}
                >
                    <option value="" disabled>Seleccione...</option>
                    {opcionesRespuestaArray.length > 0 ? (
                        opcionesRespuestaArray.map((opcion: OpcionRespuesta) => (
                            <option key={opcion.value} value={opcion.value}>{opcion.label}</option>
                        ))
                    ) : (
                        <>
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                            {pregunta.permite_desconozco && <option value="desconozco">Desconozco</option>}
                        </>
                    )}
                </select>
                
                {debeMostrarCampos() && (
                    <div className="pl-4 border-l-2 border-gray-200 space-y-3 mt-3">
                        {pregunta.tipo_pregunta === 'simple' && ( <InputText id={`detalle_${pregunta.id}`} name="detalle" label="Especifique" placeholder="Añada detalles aquí..." value={String(respuestaActual.campos?.detalle || '')} onChange={e => handleRespuestaChange(pregunta.id, 'detalle', e.target.value)} /> )}
                        {pregunta.tipo_pregunta === 'multiple_campos' && camposAdicionalesArray.map(campo => renderCampo(campo, pregunta.id))}
                        {pregunta.tipo_pregunta === 'repetible' && ( <div> {respuestaActual.items?.map((_, index) => ( <div key={index} className="border p-2 rounded-md mb-2 relative"> <button type="button" onClick={() => removeItem(pregunta.id, index)} className="absolute top-1 right-1 text-red-500 font-bold">X</button> {camposAdicionalesArray.map(campo => renderCampo(campo, pregunta.id, index))} </div> ))} <button type="button" onClick={() => addItem(pregunta.id)} className="text-sm text-blue-600 hover:underline mt-2">+ Añadir otro</button> </div> )}
                    </div>
                )}
            </div>
        );
    };
    return (
        <>
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />
            <Head title="Registro historia clínica"/>

            <FormLayout
                title="Registro historia clínica"
                onSubmit={handleSubmit}
                actions={
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                }
            >
                <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">
                    Signos vitales y padecimiento
                </h2>

                <InputTextArea
                    label='Padecimiento actual (indagar acerca de tratamientos previos'
                    id="padecimiento_actual"
                    name="padecimiento_actual"
                    value={data.padecimiento_actual}
                    onChange={(e) => setData('padecimiento_actual', e.target.value)}
                    error={errors.padecimiento_actual}
                />

                <InputText
                    id="tension_arterial"
                    name="tension_arterial"
                    label="Tensión arterial"
                    value={data.tension_arterial}
                    onChange={(e) => setData('tension_arterial', e.target.value)}
                    error={errors.tension_arterial}
                />
                <InputText
                    id="frecuencia_cardiaca"
                    name="frecuencia_cardiaca"
                    label="Frecuencia cardíaca (por minuto)"
                    type="number"
                    value={String(data.frecuencia_cardiaca)}
                    onChange={(e) => setData('frecuencia_cardiaca', e.target.value)}
                    error={errors.frecuencia_cardiaca}
                />
                <InputText
                    id="frecuencia_respiratoria"
                    name="frecuencia_respiratoria"
                    label="Frecuencia respiratoria (por minuto)"
                    type="number"
                    value={String(data.frecuencia_respiratoria)}
                    onChange={(e) => setData('frecuencia_respiratoria', e.target.value)}
                    error={errors.frecuencia_respiratoria}
                />

                <InputText
                    id="saturacion_oxigeno"
                    name="saturacion_oxigeno"
                    label="Saturación de oxígeno (%)"
                    type="number"
                    value={String(data.saturacion_oxigeno)}
                    onChange={(e) => setData('saturacion_oxigeno',Number( e.target.value))}
                    error={errors.saturacion_oxigeno}
                />

                <InputText
                    id="temperatura"
                    name="temperatura"
                    label="Temperatura (°C)"
                    type="number"
                    value={String(data.temperatura)}
                    onChange={(e) => setData('temperatura', e.target.value)}
                    error={errors.temperatura}
                />
                <InputText
                    id="peso"
                    name="peso"
                    label="Peso (kg)"
                    type="number"
                    value={String(data.peso)}
                    onChange={(e) => setData('peso', e.target.value)}
                    error={errors.peso}
                />
                <InputText
                    id="talla"
                    name="talla"
                    label="Talla (cm)"
                    type="number"
                    value={String(data.talla)}
                    onChange={(e) => setData('talla', e.target.value)}
                    error={errors.talla}
                />

                {categoriasVisibles.map(([categoria, listaPreguntas]) => (
                    <div key={categoria} className="col-span-full mt-6">
                        <h2 className="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                            {formatarTituloCategoria(categoria)}
                        </h2>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {listaPreguntas.map((pregunta) => renderPregunta(pregunta))}
                        </div>
                    </div>
                ))}

                <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">
                    Análisis, diagnóstico y plan
                </h2>

               <InputTextArea
                    label="Resultados previos y actuales de laboratorio y gabinete"
                    id="resultados_previos"
                    name="resultados_previos"
                    value={data.resultados_previos}
                    onChange={(e) => setData('resultados_previos', e.target.value)}
                    rows={4}
                    error={errors.resultados_previos}
                />

                <InputTextArea
                    label="Diagnóstico(s)"
                    id="diagnostico"
                    name="diagnostico"
                    value={data.diagnostico}
                    onChange={(e) => setData('diagnostico', e.target.value)}
                    rows={4}
                    error={errors.diagnostico}
                />

                <InputTextArea
                    label="Pronóstico"
                    id="pronostico"
                    name="pronostico"
                    value={data.pronostico}
                    onChange={(e) => setData('pronostico', e.target.value)}
                    rows={2}
                    error={errors.pronostico}
                />

                <InputTextArea
                    label="Indicación terapéutica"
                    id="indicacion_terapeutica"
                    name="indicacion_terapeutica"
                    value={data.indicacion_terapeutica}
                    onChange={(e) => setData('indicacion_terapeutica', e.target.value)}
                    rows={4}
                    error={errors.indicacion_terapeutica}
                />
            </FormLayout>
        </>
    );
};

Create.layout = (page: React.ReactElement) => {
    const { estancia } = page.props as CreateProps;

  return (
    <MainLayout
      pageTitle={`Registro historia clínica`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      {page}
    </MainLayout>
  );
};

export default Create;
