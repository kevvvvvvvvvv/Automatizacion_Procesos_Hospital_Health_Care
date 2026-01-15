import React from 'react';
import { useForm } from '@inertiajs/react';
import { Estancia, Interconsulta, Paciente } from '@/types';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import PacienteCard from '@/components/paciente-card';

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    interconsulta: Interconsulta;
    onSubmit: (form: any) => void;
    submitLabel?: string;
}

export const InterconsultaForm = ({ 
    paciente, 
    estancia, 
    interconsulta,
    onSubmit, 
    submitLabel = 'Guardar' 
}: Props) => {

    
    const form = useForm({
        ta: interconsulta?.ta || '',
        fc: interconsulta?.fc || '',
        fr: interconsulta?.fr || "",
        temp: interconsulta?.temp || "",
        peso: interconsulta?.peso || " ",
        talla: interconsulta?.talla || "",
        criterio_diagnostico: interconsulta?.criterio_diagnostico || '',
        plan_de_estudio: interconsulta?.plan_de_estudio || '',
        sugerencia_diagnostica: interconsulta?.sugerencia_diagnostica || '',
        resumen_del_interrogatorio: interconsulta?.resumen_del_interrogatorio || '',
        exploracion_fisica: interconsulta?.exploracion_fisica || '',
        estado_mental: interconsulta?.estado_mental || '',
        resultados_relevantes_del_estudio_diagnostico: interconsulta?.resultados_relevantes_del_estudio_diagnostico || '',
        tratamiento: interconsulta?.tratamiento || '',
        pronostico: interconsulta?.pronostico || '',
        motivo_de_la_atencion_o_interconsulta: interconsulta?.motivo_de_la_atencion_o_interconsulta || '',
        diagnostico_o_problemas_clinicos: interconsulta?.diagnostico_o_problemas_clinicos || '',
    });

    const { data, setData, errors, processing } = form;

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit(form);
    };

    const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white focus:ring-2 focus:ring-[#2a2b56] transition outline-none`;
    const labelClasses = `block text-sm font-semibold text-gray-700 mb-1`;

    return (
        <div className="space-y-6">
            <PacienteCard paciente={paciente} estancia={estancia} />

             <FormLayout
                title="Registrar nueva interconsulta"
                onSubmit={handleSubmit}
                actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Creando...' : 'Crear Interconsulta'}</PrimaryButton>}
            >
        {/* Sección 2: Motivo y Exploración */}
        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Motivo y exploración</h2>
        <div className="col-span-full md:col-span-1">
          <label htmlFor="motivo_de_la_atencion_o_interconsulta" className={labelClasses}>
            Motivo de la atención o interconsulta
          </label>
          <textarea
            id="motivo_de_la_atencion_o_interconsulta"
            name="motivo_de_la_atencion_o_interconsulta"
            value={data.motivo_de_la_atencion_o_interconsulta}
            onChange={(e) => setData('motivo_de_la_atencion_o_interconsulta', e.target.value)}
            placeholder="Describa el motivo principal..."
            rows={3}
            className={`${textAreaClasses} ${errors.motivo_de_la_atencion_o_interconsulta ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.motivo_de_la_atencion_o_interconsulta && (
            <p className="mt-1 text-xs text-red-500">{errors.motivo_de_la_atencion_o_interconsulta}</p>
          )}
        </div>
        <div className="col-span-full md:col-span-1">
          <label htmlFor="resumen_del_interrogatorio" className={labelClasses}>
            Resumen del interrogatorio
          </label>
          <textarea
            id="resumen_del_interrogatorio"
            name="resumen_del_interrogatorio"
            value={data.resumen_del_interrogatorio}
            onChange={(e) => setData('resumen_del_interrogatorio', e.target.value)}
            placeholder="Resumen de la historia clínica..."
            rows={3}
            className={`${textAreaClasses} ${errors.resumen_del_interrogatorio ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.resumen_del_interrogatorio && (
            <p className="mt-1 text-xs text-red-500">{errors.resumen_del_interrogatorio}</p>
          )}
        </div>
        <div className="col-span-full">
          <label htmlFor="exploracion_fisica" className={labelClasses}>
            Exploración Física
          </label>
          <textarea
            id="exploracion_fisica"
            name="exploracion_fisica"
            value={data.exploracion_fisica}
            onChange={(e) => setData('exploracion_fisica', e.target.value)}
            placeholder="Hallazgos de la exploración..."
            rows={4}
            className={`${textAreaClasses} ${errors.exploracion_fisica ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.exploracion_fisica && (
            <p className="mt-1 text-xs text-red-500">{errors.exploracion_fisica}</p>
          )}
        </div>
        <div className="col-span-full">
          <label htmlFor="estado_mental" className={labelClasses}>
            Estado Mental
          </label>
          <textarea
            id="estado_mental"
            name="estado_mental"
            value={data.estado_mental}
            onChange={(e) => setData('estado_mental', e.target.value)}
            placeholder="Evaluación del estado mental..."
            rows={3}
            className={`${textAreaClasses} ${errors.estado_mental ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.estado_mental && (
            <p className="mt-1 text-xs text-red-500">{errors.estado_mental}</p>
          )}
        </div>

        {/* Sección 1: Signos Vitales */}
        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Signos Vitales</h2>
        <InputText
          id="ta"
          label="Tensión arterial"
          name="ta"
          value={data.ta?.toString() || ''}
          onChange={(e) => setData('ta', e.target.value)}
          placeholder="Ej: 120/80"
          error={errors.ta}
        />
        <InputText
          id="fc"
          label="Frecuencia cardíaca"
          name="fc"
          type="number"
          value={data.fc?.toString() || ''}
          onChange={(e) => setData('fc', e.target.value)}
          placeholder="Ej: 70"
          error={errors.fc}
        />
        <InputText
          id="fr"
          label="Frecuencia respiratoria)"
          name="fr"
          type="number"
          value={data.fr?.toString() || ''}
          onChange={(e) => setData('fr', e.target.value)}
          placeholder="Ej: 16"
          error={errors.fr}
        />
        <InputText
          id="temp"
          label="Temperatura"
          name="temp"
          type="number"
          value={data.temp?.toString() || ''}
          onChange={(e) => setData('temp', e.target.value)}
          placeholder="Ej: 36.50"
          error={errors.temp}
        />
        <InputText
          id="peso"
          label="Peso (kg)"
          name="peso"
          type="number"
          value={data.peso?.toString() || ''}
          onChange={(e) => setData('peso', e.target.value)}
          placeholder="Ej: 70.50"
          error={errors.peso}
        />
        <InputText
          id="talla"
          label="Talla (m)"
          name="talla"
          type="number"
          value={data.talla?.toString() || ''}
          onChange={(e) => setData('talla', e.target.value)}
          placeholder="Ej: 1.75"
          error={errors.talla}
        />

        
        {/* Sección 3: Diagnóstico y Plan */}
        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Diagnóstico y Plan</h2>
        <div className="col-span-full">
          <label htmlFor="criterio_diagnostico" className={labelClasses}>
            Criterio Diagnóstico
          </label>
          <textarea
            id="criterio_diagnostico"
            name="criterio_diagnostico"
            value={data.criterio_diagnostico}
            onChange={(e) => setData('criterio_diagnostico', e.target.value)}
            placeholder="Criterios usados para el diagnóstico..."
            rows={3}
            className={`${textAreaClasses} ${errors.criterio_diagnostico ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.criterio_diagnostico && (
            <p className="mt-1 text-xs text-red-500">{errors.criterio_diagnostico}</p>
          )}
        </div>
        <div className="col-span-full">
          <label htmlFor="plan_de_estudio" className={labelClasses}>
            Plan de Estudio
          </label>
          <textarea
            id="plan_de_estudio"
            name="plan_de_estudio"
            value={data.plan_de_estudio}
            onChange={(e) => setData('plan_de_estudio', e.target.value)}
            placeholder="Plan de estudios adicionales..."
            rows={3}
            className={`${textAreaClasses} ${errors.plan_de_estudio ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.plan_de_estudio && (
            <p className="mt-1 text-xs text-red-500">{errors.plan_de_estudio}</p>
          )}
        </div>
        <div className="col-span-full">
          <label htmlFor="sugerencia_diagnostica" className={labelClasses}>
            Sugerencia Diagnóstica
          </label>
          <textarea
            id="sugerencia_diagnostica"
            name="sugerencia_diagnostica"
            value={data.sugerencia_diagnostica}
            onChange={(e) => setData('sugerencia_diagnostica', e.target.value)}
            placeholder="Sugerencias adicionales..."
            rows={3}
            className={`${textAreaClasses} ${errors.sugerencia_diagnostica ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.sugerencia_diagnostica && (
            <p className="mt-1 text-xs text-red-500">{errors.sugerencia_diagnostica}</p>
          )}
        </div>
        <div className="col-span-full">
          <label htmlFor="resultados_relevantes_del_estudio_diagnostico" className={labelClasses}>
            Resultado de estudios de los servicios auxiliares de diagnóstico y tratamiento
          </label>
          <textarea
            id="resultados_relevantes_del_estudio_diagnostico"
            name="resultados_relevantes_del_estudio_diagnostico"
            value={data.resultados_relevantes_del_estudio_diagnostico}
            onChange={(e) => setData('resultados_relevantes_del_estudio_diagnostico', e.target.value)}
            placeholder="Resultados de exámenes relevantes..."
            rows={4}
            className={`${textAreaClasses} ${errors.resultados_relevantes_del_estudio_diagnostico ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.resultados_relevantes_del_estudio_diagnostico && (
            <p className="mt-1 text-xs text-red-500">{errors.resultados_relevantes_del_estudio_diagnostico}</p>
          )}
        </div>
        <div className="col-span-full">
          <label htmlFor="diagnostico_o_problemas_clinicos" className={labelClasses}>
            Diagnóstico o Problemas Clínicos
          </label>
          <textarea
            id="diagnostico_o_problemas_clinicos"
            name="diagnostico_o_problemas_clinicos"
            value={data.diagnostico_o_problemas_clinicos}
            onChange={(e) => setData('diagnostico_o_problemas_clinicos', e.target.value)}
            placeholder="Diagnósticos principales..."
            rows={3}
            className={`${textAreaClasses} ${errors.diagnostico_o_problemas_clinicos ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.diagnostico_o_problemas_clinicos && (
            <p className="mt-1 text-xs text-red-500">{errors.diagnostico_o_problemas_clinicos}</p>
          )}
        </div>
        <div className="col-span-full">
          <label htmlFor="tratamiento" className={labelClasses}>
            Tratamiento
          </label>
          <textarea
            id="tratamiento"
            name="tratamiento"
            value={data.tratamiento}
            onChange={(e) => setData('tratamiento', e.target.value)}
            placeholder="Tratamiento recomendado y pronóstico..35."
            rows={4}
            className={`${textAreaClasses} ${errors.tratamiento ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.tratamiento && (
            <p className="mt-1 text-xs text-red-500">{errors.tratamiento}</p>
          )}
        </div>
         <div className="col-span-full">
          <label htmlFor="pronostico" className={labelClasses}>
            Pronóstico
          </label>
          <textarea
            id="pronostico"
            name="pronostico"
            value={data.pronostico}
            onChange={(e) => setData('pronostico', e.target.value)}
            placeholder="Tratamiento recomendado y pronóstico..."
            rows={4}
            className={`${textAreaClasses} ${errors.pronostico ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.pronostico && (
            <p className="mt-1 text-xs text-red-500">{errors.pronostico}</p>
          )}
        </div>
        
      </FormLayout>
        </div>
    );
};