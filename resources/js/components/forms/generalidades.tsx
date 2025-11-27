import React from 'react';

import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';

const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;
const textAreaClasses = `w-full rounded-md shadow-sm border px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500`;

interface GeneralidadesProps {
    data: {
        ta?: string;
        fc?: string ;
        fr?: string ;
        temp?: string ;
        peso?: string ;
        talla?: string ;
        resumen_del_interrogatorio?: string;
        exploracion_fisica?: string;
        resultado_estudios?: string;
        diagnostico_o_problemas_clinicos?: string;
        plan_de_estudio?: string;
        pronostico?: string;
    };
    setData: (field: string, value: string) => void;
    errors: Record<string, string | undefined>;
}

const Generalidades: React.FC<GeneralidadesProps> = ({ data, setData, errors }) => {
  return (
    <>
      {/* Sección 1: Signos Vitales */}
      <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">
        Signos Vitales
      </h2>

      <InputText
        id="ta"
        label="T.A. (Tensión Arterial)"
        name="ta"
        value={data.ta ?? ''}
        onChange={(e) => setData('ta', e.target.value)}
        placeholder="Ej: 120/80"
        error={errors.ta}
      />

      <InputText
        id="fc"
        label="FC (Frecuencia Cardíaca)"
        name="fc"
        type="number"
        value={data.fc ?? ''}
        onChange={(e) => setData('fc', e.target.value)}
        placeholder="Ej: 70"
        error={errors.fc}
      />

      <InputText
        id="fr"
        label="FR (Frecuencia Respiratoria)"
        name="fr"
        type="number"
        value={data.fr ?? ''}
        onChange={(e) => setData('fr', e.target.value)}
        placeholder="Ej: 16"
        error={errors.fr}
      />

      <InputText
        id="temp"
        label="TEMP (Temperatura)"
        name="temp"
        type="number"
        value={data.temp ?? ''}
        onChange={(e) => setData('temp', e.target.value)}
        placeholder="Ej: 36.5"
        error={errors.temp}
      />

      <InputText
        id="peso"
        label="Peso (kg)"
        name="peso"
        type="number"
        value={data.peso ?? ''}
        onChange={(e) => setData('peso', e.target.value)}
        placeholder="Ej: 70.5"
        error={errors.peso}
      />

      <InputText
        id="talla"
        label="Talla (m)"
        name="talla"
        type="number"
        value={data.talla ?? ''}
        onChange={(e) => setData('talla', e.target.value)}
        placeholder="Ej: 1.75"
        error={errors.talla}
      />

      {/* Resumen del Interrogatorio */}
      <div className="col-span-full md:col-span-1">
        <label htmlFor="resumen_del_interrogatorio" className={labelClasses}>
          Resumen del Interrogatorio
        </label>
        <textarea
          id="resumen_del_interrogatorio"
          name="resumen_del_interrogatorio"
          value={data.resumen_del_interrogatorio ?? ''}
          onChange={(e) => setData('resumen_del_interrogatorio', e.target.value)}
          placeholder="Resumen de la historia clínica..."
          rows={3}
          className={`${textAreaClasses} ${
            errors.resumen_del_interrogatorio ? 'border-red-500' : 'border-gray-600'
          }`}
          autoComplete="off"
        />
        {errors.resumen_del_interrogatorio && (
          <p className="mt-1 text-xs text-red-500">
            {errors.resumen_del_interrogatorio}
          </p>
        )}
      </div>

      {/* Exploración Física */}
      <div className="col-span-full">
        <label htmlFor="exploracion_fisica" className={labelClasses}>
          Exploración Física
        </label>
        <textarea
          id="exploracion_fisica"
          name="exploracion_fisica"
          value={data.exploracion_fisica ?? ''}
          onChange={(e) => setData('exploracion_fisica', e.target.value)}
          placeholder="Hallazgos de la exploración..."
          rows={4}
          className={`${textAreaClasses} ${
            errors.exploracion_fisica ? 'border-red-500' : 'border-gray-600'
          }`}
          autoComplete="off"
        />
        {errors.exploracion_fisica && (
          <p className="mt-1 text-xs text-red-500">
            {errors.exploracion_fisica}
          </p>
        )}
      </div>

      <InputText
        id="resultado_estudios"
        name="resultado_estudios"
        label="Resultado de estudios de los servicios auxiliares de diagnóstico y tratamiento"
        value={data.resultado_estudios ?? ''}
        onChange={(value)=>(setData('resultado_estudios',value.target.value))}
        error={errors.resultado_estudios}
      />

      {/* Resultados de estudios auxiliares, diagnóstico y plan */}
      <div className="col-span-full">
        <label htmlFor="diagnostico_o_problemas_clinicos" className={labelClasses}>
          Diagnóstico o Problemas Clínicos
        </label>
        <textarea
          id="diagnostico_o_problemas_clinicos"
          name="diagnostico_o_problemas_clinicos"
          value={data.diagnostico_o_problemas_clinicos ?? ''}
          onChange={(e) =>
            setData('diagnostico_o_problemas_clinicos', e.target.value)
          }
          placeholder="Diagnósticos principales..."
          rows={3}
          className={`${textAreaClasses} ${
            errors.diagnostico_o_problemas_clinicos ? 'border-red-500' : 'border-gray-600'
          }`}
          autoComplete="off"
        />
        {errors.diagnostico_o_problemas_clinicos && (
          <p className="mt-1 text-xs text-red-500">
            {errors.diagnostico_o_problemas_clinicos}
          </p>
        )}
      </div>

      <div className="col-span-full">
        <label htmlFor="plan_de_estudio" className={labelClasses}>
          Plan de Estudio
        </label>
        <textarea
          id="plan_de_estudio"
          name="plan_de_estudio"
          value={data.plan_de_estudio ?? ''}
          onChange={(e) => setData('plan_de_estudio', e.target.value)}
          placeholder="Plan de estudios adicionales..."
          rows={3}
          className={`${textAreaClasses} ${
            errors.plan_de_estudio ? 'border-red-500' : 'border-gray-600'
          }`}
          autoComplete="off"
        />
        {errors.plan_de_estudio && (
          <p className="mt-1 text-xs text-red-500">
            {errors.plan_de_estudio}
          </p>
        )}
      </div>

      {/* Pronóstico */}
      <div className="mb-4 col-span-full">
        <label htmlFor="pronostico" className={labelClasses}>
          Pronóstico
        </label>
        <textarea
          id="pronostico"
          className={textAreaClasses}
          value={data.pronostico ?? ''}
          onChange={(e) => setData('pronostico', e.target.value)}
          placeholder="Describa el pronóstico al egreso"
          rows={4}
          autoComplete="off"
        />
        {errors.pronostico  && (
          <div className="text-red-500 'border-gray-600'">{errors.pronostico}</div>
        )}
      </div>
    </>
  );
    return (
        <>
            <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">
                Signos Vitales
            </h2>

            <InputText
                id="ta"
                label="Tensión arterial"
                name="ta"
                value={data.ta ?? ''}
                onChange={(e) => setData('ta', e.target.value)}
                placeholder="Ej: 120/80"
                error={errors.ta}
            />

            <InputText
                id="fc"
                label="Frecuencia cardiaca"
                name="fc"
                type="number"
                value={data.fc ?? ''}
                onChange={(e) => setData('fc', e.target.value)}
                placeholder="Ej: 70"
                error={errors.fc}
            />

            <InputText
                id="fr"
                label="Frecuencia respiratoria"
                name="fr"
                type="number"
                value={data.fr ?? ''}
                onChange={(e) => setData('fr', e.target.value)}
                placeholder="Ej: 16"
                error={errors.fr}
            />

            <InputText
                id="temp"
                label="Temperatura (ºC)"
                name="temp"
                type="number"
                value={data.temp ?? ''}
                onChange={(e) => setData('temp', e.target.value)}
                placeholder="Ej: 36.5"
                error={errors.temp}
            />

            <InputText
                id="peso"
                label="Peso (kg)"
                name="peso"
                type="number"
                value={data.peso ?? ''}
                onChange={(e) => setData('peso', e.target.value)}
                placeholder="Ej: 70.5"
                error={errors.peso}
            />

            <InputText
                id="talla"
                label="Talla (cm)"
                name="talla"
                type="number"
                value={data.talla ?? ''}
                onChange={(e) => setData('talla', e.target.value)}
                placeholder="Ej: 1.75"
                error={errors.talla}
            />

            <div className="col-span-full md:col-span-1">
                <label htmlFor="resumen_del_interrogatorio" className={labelClasses}>
                Resumen del Interrogatorio
                </label>
                <textarea
                id="resumen_del_interrogatorio"
                name="resumen_del_interrogatorio"
                value={data.resumen_del_interrogatorio ?? ''}
                onChange={(e) => setData('resumen_del_interrogatorio', e.target.value)}
                placeholder="Resumen de la historia clínica..."
                rows={3}
                className={`${textAreaClasses} ${
                    errors.resumen_del_interrogatorio ? 'border-red-500' : 'border-gray-600'
                }`}
                autoComplete="off"
                />
                {errors.resumen_del_interrogatorio && (
                <p className="mt-1 text-xs text-red-500">
                    {errors.resumen_del_interrogatorio}
                </p>
                )}
            </div>

            <div className="col-span-full">
                <label htmlFor="exploracion_fisica" className={labelClasses}>
                Exploración Física
                </label>
                <textarea
                id="exploracion_fisica"
                name="exploracion_fisica"
                value={data.exploracion_fisica ?? ''}
                onChange={(e) => setData('exploracion_fisica', e.target.value)}
                placeholder="Hallazgos de la exploración..."
                rows={4}
                className={`${textAreaClasses} ${
                    errors.exploracion_fisica ? 'border-red-500' : 'border-gray-600'
                }`}
                autoComplete="off"
                />
                {errors.exploracion_fisica && (
                <p className="mt-1 text-xs text-red-500">
                    {errors.exploracion_fisica}
                </p>
                )}
            </div>

            <InputTextArea
                id='resultado_estudios'
                label="Resultado de estudios de los servicios auxiliares de diagnóstico y tratamiento"
                value={data.resultado_estudios ?? ''}
                onChange={(e)=>setData('resultado_estudios', e.target.value)}
                rows={4}
                error={errors.resultado_estudios}
            />

            <div className="col-span-full">
                <label htmlFor="diagnostico_o_problemas_clinicos" className={labelClasses}>
                Diagnóstico o Problemas Clínicos
                </label>
                <textarea
                id="diagnostico_o_problemas_clinicos"
                name="diagnostico_o_problemas_clinicos"
                value={data.diagnostico_o_problemas_clinicos ?? ''}
                onChange={(e) =>
                    setData('diagnostico_o_problemas_clinicos', e.target.value)
                }
                placeholder="Diagnósticos principales..."
                rows={3}
                className={`${textAreaClasses} ${
                    errors.diagnostico_o_problemas_clinicos ? 'border-red-500' : 'border-gray-600'
                }`}
                autoComplete="off"
                />
                {errors.diagnostico_o_problemas_clinicos && (
                <p className="mt-1 text-xs text-red-500">
                    {errors.diagnostico_o_problemas_clinicos}
                </p>
                )}
            </div>

            <div className="col-span-full">
                <label htmlFor="plan_de_estudio" className={labelClasses}>
                Plan de Estudio
                </label>
                <textarea
                id="plan_de_estudio"
                name="plan_de_estudio"
                value={data.plan_de_estudio ?? ''}
                onChange={(e) => setData('plan_de_estudio', e.target.value)}
                placeholder="Plan de estudios adicionales..."
                rows={3}
                className={`${textAreaClasses} ${
                    errors.plan_de_estudio ? 'border-red-500' : 'border-gray-600'
                }`}
                autoComplete="off"
                />
                {errors.plan_de_estudio && (
                <p className="mt-1 text-xs text-red-500">
                    {errors.plan_de_estudio}
                </p>
                )}
            </div>

            <div className="mb-4 col-span-full">
                <label htmlFor="pronostico" className={labelClasses}>
                Pronóstico
                </label>
                <textarea
                id="pronostico"
                className={textAreaClasses}
                value={data.pronostico ?? ''}
                onChange={(e) => setData('pronostico', e.target.value)}
                placeholder="Describa el pronóstico al egreso"
                rows={4}
                autoComplete="off"
                />
                {errors.pronostico && (
                <div className="text-red-500 text-sm">{errors.pronostico}</div>
                )}
            </div>
        </>
    );
};

export default Generalidades;
