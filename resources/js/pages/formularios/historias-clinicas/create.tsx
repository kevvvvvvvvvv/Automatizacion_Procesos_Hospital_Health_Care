import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React, { useMemo } from 'react';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';

interface Pregunta {
    id: number;
    pregunta: string;
    categoria: string;
}

interface Respuesta {
    catalogo_pregunta_id: number;
    respuesta: string;
    comentario: string;
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
    respuestas: Respuesta[];
}

interface CreateProps {
    preguntas: Pregunta[];
}

type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const Create: CreateComponent = ({ preguntas }) => {

    const { data, setData, post, processing, errors } = useForm<FormData>({
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
        respuestas: preguntas.map(p => ({
            catalogo_pregunta_id: p.id,
            respuesta: '',
            comentario: '',
        })),
    });

    const preguntasPorCategoria = useMemo(() => {
        return preguntas.reduce((acc, pregunta) => {
            (acc[pregunta.categoria] = acc[pregunta.categoria] || []).push(pregunta);
            return acc;
        }, {} as Record<string, Pregunta[]>);
    }, [preguntas]);
    
    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('historia.clinica.store'));
    };

    const handleRespuestaChange = (preguntaId: number, field: 'respuesta' | 'comentario', value: string) => {
        setData('respuestas', data.respuestas.map(r => {
            if (r.catalogo_pregunta_id === preguntaId) {

                const updatedRespuesta = { ...r, [field]: value };

                if (field === 'respuesta' && value.toLowerCase() !== 'si') {
                    updatedRespuesta.comentario = '';
                }
                return updatedRespuesta;
            }
            return r; 
        }));
    };

    const formatarTituloCategoria = (categoria: string) => {
        return categoria.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    };

    const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;
    const textAreaErrorClasses = `border-red-500 focus:ring-red-500 focus:border-red-500`;
    const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;


    return(
        <FormLayout
            title="Registrar Nueva Historia Clínica"
            onSubmit={handleSubmit}
            actions={
                <PrimaryButton type="submit" disabled={processing}>
                    {processing ? 'Guardando...' : 'Guardar'}
                </PrimaryButton>
            }
        >
            <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Signos Vitales y Padecimiento</h2>
            
            <div className="col-span-full">
                 <label htmlFor="padecimiento_actual" className={labelClasses}>Padecimiento Actual</label>
                 <textarea
                    id="padecimiento_actual"
                    name="padecimiento_actual"
                    value={data.padecimiento_actual}
                    onChange={(e) => setData('padecimiento_actual', e.target.value)}
                    rows={4}
                    className={`${textAreaClasses} ${errors.padecimiento_actual ? textAreaErrorClasses : 'border-gray-600'}`}
                 />
                 {errors.padecimiento_actual && <p className="mt-1 text-xs text-red-500">{errors.padecimiento_actual}</p>}
            </div>
            
            <InputText id="tension_arterial" name="tension_arterial" label="Tensión Arterial" value={data.tension_arterial} onChange={(e) => setData('tension_arterial', e.target.value)} error={errors.tension_arterial} />
            <InputText id="frecuencia_cardiaca" name="frecuencia_cardiaca" label="Frecuencia Cardíaca (x min)" type="number" value={String(data.frecuencia_cardiaca)} onChange={(e) => setData('frecuencia_cardiaca', e.target.value)} error={errors.frecuencia_cardiaca} />
            <InputText id="frecuencia_respiratoria" name="frecuencia_respiratoria" label="Frecuencia Respiratoria (x min)" type="number" value={String(data.frecuencia_respiratoria)} onChange={(e) => setData('frecuencia_respiratoria', e.target.value)} error={errors.frecuencia_respiratoria} />
            <InputText id="temperatura" name="temperatura" label="Temperatura (°C)" type="number" value={String(data.temperatura)} onChange={(e) => setData('temperatura', e.target.value)} error={errors.temperatura} />
            <InputText id="peso" name="peso" label="Peso (kg)" type="number" value={String(data.peso)} onChange={(e) => setData('peso', e.target.value)} error={errors.peso} />
            <InputText id="talla" name="talla" label="Talla (cm)" type="number" value={String(data.talla)} onChange={(e) => setData('talla', e.target.value)} error={errors.talla} />

            {Object.entries(preguntasPorCategoria).map(([categoria, listaPreguntas]) => (
                <div key={categoria} className="col-span-full mt-6">
                    <h2 className="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                        {formatarTituloCategoria(categoria)}
                    </h2>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                        {listaPreguntas.map(pregunta => {
                            const respuestaActual = data.respuestas.find(r => r.catalogo_pregunta_id === pregunta.id);

                            return (
                                <div key={pregunta.id} className="col-span-1 flex flex-col space-y-2">
                                    <div>
                                        <label htmlFor={`respuesta_${pregunta.id}`} className={labelClasses}>
                                            {pregunta.pregunta}
                                        </label>
                                        <select
                                            id={`respuesta_${pregunta.id}`}
                                            name={`respuesta_${pregunta.id}`}
                                            value={respuestaActual?.respuesta || ''}
                                            onChange={e => handleRespuestaChange(pregunta.id, 'respuesta', e.target.value)}
                                            className={`${textAreaClasses} border-gray-600`} 
                                        >
                                            <option value="" disabled>Seleccione...</option>
                                            <option value="si">Sí</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    {respuestaActual?.respuesta === 'si' && (
                                        <div>
                                            <InputText
                                                id={`comentario_${pregunta.id}`}
                                                name={`comentario_${pregunta.id}`}
                                                label="Comentario (opcional)"
                                                placeholder="Detalles..."
                                                value={respuestaActual?.comentario || ''}
                                                onChange={e => handleRespuestaChange(pregunta.id, 'comentario', e.target.value)}
                                            />
                                        </div>
                                    )}
                                </div>
                            );
                        })}
                    </div>
                </div>
            ))}
            
            <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Análisis, Diagnóstico y Plan</h2>
            <div className="col-span-full">
                <label htmlFor="resultados_previos" className={labelClasses}>Resultados Previos y Actuales de Laboratorio y Gabinete</label>
                <textarea id="resultados_previos" name="resultados_previos" value={data.resultados_previos} onChange={e => setData('resultados_previos', e.target.value)} rows={4} className={`${textAreaClasses} ${errors.resultados_previos ? textAreaErrorClasses : 'border-gray-600'}`} />
                {errors.resultados_previos && <p className="mt-1 text-xs text-red-500">{errors.resultados_previos}</p>}
            </div>
            <div className="col-span-full">
                <label htmlFor="diagnostico" className={labelClasses}>Diagnóstico(s)</label>
                <textarea id="diagnostico" name="diagnostico" value={data.diagnostico} onChange={e => setData('diagnostico', e.target.value)} rows={4} className={`${textAreaClasses} ${errors.diagnostico ? textAreaErrorClasses : 'border-gray-600'}`} />
                {errors.diagnostico && <p className="mt-1 text-xs text-red-500">{errors.diagnostico}</p>}
            </div>
            <div className="col-span-full">
                <label htmlFor="pronostico" className={labelClasses}>Pronóstico</label>
                <textarea id="pronostico" name="pronostico" value={data.pronostico} onChange={e => setData('pronostico', e.target.value)} rows={2} className={`${textAreaClasses} ${errors.pronostico ? textAreaErrorClasses : 'border-gray-600'}`} />
                {errors.pronostico && <p className="mt-1 text-xs text-red-500">{errors.pronostico}</p>}
            </div>
            <div className="col-span-full">
                <label htmlFor="indicacion_terapeutica" className={labelClasses}>Indicación Terapéutica</label>
                <textarea id="indicacion_terapeutica" name="indicacion_terapeutica" value={data.indicacion_terapeutica} onChange={e => setData('indicacion_terapeutica', e.target.value)} rows={4} className={`${textAreaClasses} ${errors.indicacion_terapeutica ? textAreaErrorClasses : 'border-gray-600'}`} />
                {errors.indicacion_terapeutica && <p className="mt-1 text-xs text-red-500">{errors.indicacion_terapeutica}</p>}
            </div>
        </FormLayout>
    );
};

Create.layout = (page: React.ReactElement) => {
    return (
        <MainLayout pageTitle="Creación de Historia Clínica" children={page} />
    );
};

export default Create;