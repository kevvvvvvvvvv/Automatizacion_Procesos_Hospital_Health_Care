  import React, { useState, useEffect } from 'react';
  import { Head, useForm, router } from '@inertiajs/react';
  import MainLayout from '@/layouts/MainLayout';  
  import { route } from 'ziggy-js';
  import InputText from '@/components/ui/input-text';
  import BackButton from '@/components/ui/back-button';
  import { Estancia } from '@/types';

 type Props = {
  pacientes?: { id: number; nombre_completo: string }[];
  estancia?: Estancia;  // Agrega estancia a las props
};
  console.log('CreateInterconsulta component loaded successfully');
const CreateInterconsulta: React.FC<Props> = ({ pacientes = [], estancia }) => {
      useEffect(() => {
    console.log('Props recibidas en CreateInterconsulta:', {
      pacientes: pacientes || 'UNDEFINED!',
      numPacientes: pacientes?.length || 0,
      estancia: estancia || 'UNDEFINED!',  // Ahora debería tener la estancia
    });
  }, [pacientes, estancia]);

    const { data, setData, post, processing, errors } = useForm({
      paciente_id: '',
      ta: '',
      fc: '',
      fr: '',
      temp: '',
      peso: '',
      talla: '',
      criterio_diagnostico: '',
      plan_de_estudio: '',
      sugerencia_diagnostica: '',
      motivo_de_la_atencion_o_interconsulta: '',
      resumen_del_interrogatorio: '',
      exploracion_fisica: '',
      estado_mental: '',
      resultados_relevantes_del_estudio_diagnostico: '',
      diagnostico_o_problemas_clinicos: '',
      tratamiento_y_pronostico: '',
    });

     const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!data.paciente_id) {
      alert('Debe seleccionar un paciente.');
      return;
    }
    if (!estancia?.id) {
      alert('No se encontró la estancia. Verifica la URL.');
      return;
    }
    // Usa la ruta anidada con parámetros
    post(route('pacientes.estancias.interconsultas.store', {
      paciente: data.paciente_id,
      estancia: estancia.id
    }));
  };

    return (
      <MainLayout>
        <Head title="Crear Interconsulta" />
        <div className="p-4 md:p-8">
          <div className="flex justify-between items-center mb-6">
            <div className="flex items-center space-x-4">
              {/* Opcional: Más botones si necesitas */}
            </div>
            <BackButton />
            <h1 className="flex-1 text-center text-3xl font-bold text-black">
              Crear Nueva Interconsulta
            </h1>
          </div>

          <form onSubmit={handleSubmit} className="bg-white rounded-lg shadow p-6 max-w-6xl mx-auto">
            {/* Sección 1: Selección de Paciente */}
            <div className="mb-6">
              <h2 className="text-lg font-semibold mb-4">1. Paciente</h2>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="flex flex-col">
                  <label htmlFor="paciente_id" className="block text-sm font-medium text-gray-700 mb-2">
                    Paciente *
                  </label>
                  <select
                    id="paciente_id"
                    name="paciente_id"
                    value={data.paciente_id}
                    onChange={(e) => setData('paciente_id', e.target.value)}
                    required
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  >
                    <option value="">Seleccionar Paciente</option>
                    {pacientes.map((paciente) => (
                      <option key={paciente.id} value={paciente.id.toString()}>
                        {paciente.nombre_completo}
                      </option>
                    ))}
                  </select>
                  {errors.paciente_id && <p className="text-red-500 text-sm mt-1">{errors.paciente_id}</p>}
                </div>
              </div>
            </div>

            {/* Sección 2: Signos Vitales */}
            <div className="mb-6">
              <h2 className="text-lg font-semibold mb-4">2. Signos Vitales (Opcionales)</h2>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <InputText
                  id="ta"
                  label="T.A. (Tensión Arterial)"
                  name="ta"
                  value={data.ta}
                  onChange={(e) => setData('ta', e.target.value)}
                  placeholder="Ej: 120/80"
                  error={errors.ta}
                />

                <InputText
                  id="fc"
                  label="FC (Frecuencia Cardíaca)"
                  name="fc"
                  type="number"
                  value={data.fc}
                  onChange={(e) => setData('fc', e.target.value)}
                  placeholder="Ej: 80"
                  min={0}
                  error={errors.fc}
                />

                <InputText
                  id="fr"
                  label="FR (Frecuencia Respiratoria)"
                  name="fr"
                  type="number"
                  value={data.fr}
                  onChange={(e) => setData('fr', e.target.value)}
                  placeholder="Ej: 16"
                  min={0}
                  error={errors.fr}
                />

                <InputText
                  id="temp"
                  label="TEMP (Temperatura)"
                  name="temp"
                  type="number"
                  step="0.01"
                  value={data.temp}
                  onChange={(e) => setData('temp', e.target.value)}
                  placeholder="Ej: 36.50"
                  min={0}
                  error={errors.temp}
                />

                <InputText
                  id="peso"
                  label="Peso (kg)"
                  name="peso"
                  type="number"
                  step="0.01"
                  value={data.peso}
                  onChange={(e) => setData('peso', e.target.value)}
                  placeholder="Ej: 70.50"
                  min={0}
                  error={errors.peso}
                />

                <InputText
                  id="talla"
                  label="Talla (m)"
                  name="talla"
                  type="number"
                  step="0.01"
                  value={data.talla}
                  onChange={(e) => setData('talla', e.target.value)}
                  placeholder="Ej: 1.75"
                  min={0}
                  error={errors.talla}
                />
              </div>
            </div>

            {/* Sección 3: Motivo y Exploración */}
            <div className="mb-6">
              <h2 className="text-lg font-semibold mb-4">3. Motivo y Exploración (Opcionales)</h2>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {/* Motivo de la Atención o Interconsulta */}
                <div className="flex flex-col">
                  <label htmlFor="motivo_de_la_atencion_o_interconsulta" className="block text-sm font-medium text-gray-700 mb-2">
                    Motivo de la Atención o Interconsulta
                  </label>
                  <textarea
                    id="motivo_de_la_atencion_o_interconsulta"
                    name="motivo_de_la_atencion_o_interconsulta"
                    value={data.motivo_de_la_atencion_o_interconsulta}
                    onChange={(e) => setData('motivo_de_la_atencion_o_interconsulta', e.target.value)}
                    placeholder="Describa el motivo principal..."
                    rows={3}
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    autoComplete="off"
                  />
                  {errors.motivo_de_la_atencion_o_interconsulta && (
                    <p className="text-red-500 text-sm mt-1">{errors.motivo_de_la_atencion_o_interconsulta}</p>
                  )}
                </div>

                {/* Resumen del Interrogatorio */}
                <div className="flex flex-col">
                  <label htmlFor="resumen_del_interrogatorio" className="block text-sm font-medium text-gray-700 mb-2">
                    Resumen del Interrogatorio
                  </label>
                  <textarea
                    id="resumen_del_interrogatorio"
                    name="resumen_del_interrogatorio"
                    value={data.resumen_del_interrogatorio}
                    onChange={(e) => setData('resumen_del_interrogatorio', e.target.value)}
                    placeholder="Resumen de la historia clínica..."
                    rows={3}
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    autoComplete="off"
                  />
                  {errors.resumen_del_interrogatorio && (
                    <p className="text-red-500 text-sm mt-1">{errors.resumen_del_interrogatorio}</p>
                  )}
                </div>

                {/* Exploración Física - Ocupa toda la fila */}
                <div className="md:col-span-2 flex flex-col">
                  <label htmlFor="exploracion_fisica" className="block text-sm font-medium text-gray-700 mb-2">
                    Exploración Física
                  </label>
                  <textarea
                    id="exploracion_fisica"
                    name="exploracion_fisica"
                    value={data.exploracion_fisica}
                    onChange={(e) => setData('exploracion_fisica', e.target.value)}
                    placeholder="Hallazgos de la exploración..."
                    rows={4}
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    autoComplete="off"
                  />
                  {errors.exploracion_fisica && (
                    <p className="text-red-500 text-sm mt-1">{errors.exploracion_fisica}</p>
                  )}
                </div>

                {/* Estado Mental - Ocupa toda la fila */}
                <div className="md:col-span-2 flex flex-col">
                  <label htmlFor="estado_mental" className="block text-sm font-medium text-gray-700 mb-2">
                    Estado Mental
                  </label>
                  <textarea
                    id="estado_mental"
                    name="estado_mental"
                    value={data.estado_mental}
                    onChange={(e) => setData('estado_mental', e.target.value)}
                    placeholder="Evaluación del estado mental..."
                    rows={3}
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    autoComplete="off"
                  />
                  {errors.estado_mental && (
                    <p className="text-red-500 text-sm mt-1">{errors.estado_mental}</p>
                  )}
                </div>
              </div>
            </div>

            {/* Sección 4: Diagnóstico y Plan */}
            <div className="mb-6">
              <h2 className="text-lg font-semibold mb-4">4. Diagnóstico y Plan (Opcionales)</h2>
              <div className="grid grid-cols-1 gap-6">
                {/* Criterio Diagnóstico */}
                <div className="flex flex-col">
                  <label htmlFor="criterio_diagnostico" className="block text-sm font-medium text-gray-700 mb-2">
                    Criterio Diagnóstico
                  </label>
                  <textarea
                    id="criterio_diagnostico"
                    name="criterio_diagnostico"
                    value={data.criterio_diagnostico}
                    onChange={(e) => setData('criterio_diagnostico', e.target.value)}
                    placeholder="Criterios usados para el diagnóstico..."
                    rows={3}
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    autoComplete="off"
                  />
                  {errors.criterio_diagnostico && (
                    <p className="text-red-500 text-sm mt-1">{errors.criterio_diagnostico}</p>
                  )}
                </div>

                {/* Sugerencia Diagnóstica */}
                <div className="flex flex-col">
                  <label htmlFor="sugerencia_diagnostica" className="block text-sm font-medium text-gray-700 mb-2">
                    Sugerencia Diagnóstica
                  </label>
                  <textarea
                    id="sugerencia_diagnostica"
                    name="sugerencia_diagnostica"
                    value={data.sugerencia_diagnostica}
                    onChange={(e) => setData('sugerencia_diagnostica', e.target.value)}
                    placeholder="Sugerencias adicionales..."
                    rows={3}
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    autoComplete="off"
                  />
                  {errors.sugerencia_diagnostica && (
                    <p className="text-red-500 text-sm mt-1">{errors.sugerencia_diagnostica}</p>
                  )}
                </div>

                {/* Resultados Relevantes del Estudio Diagnóstico */}
                <div className="flex flex-col">
                  <label htmlFor="resultados_relevantes_del_estudio_diagnostico" className="block text-sm font-medium text-gray-700 mb-2">
                    Resultados Relevantes del Estudio Diagnóstico
                  </label>
                  <textarea
                    id="resultados_relevantes_del_estudio_diagnostico"
                    name="resultados_relevantes_del_estudio_diagnostico"
                    value={data.resultados_relevantes_del_estudio_diagnostico}
                    onChange={(e) => setData('resultados_relevantes_del_estudio_diagnostico', e.target.value)}
                    placeholder="Resultados de exámenes relevantes..."
                    rows={4}
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    autoComplete="off"
                  />
                  {errors.resultados_relevantes_del_estudio_diagnostico && (
                    <p className="text-red-500 text-sm mt-1">{errors.resultados_relevantes_del_estudio_diagnostico}</p>
                  )}
                </div>

                {/* Diagnóstico o Problemas Clínicos */}
                <div className="flex flex-col">
                  <label htmlFor="diagnostico_o_problemas_clinicos" className="block text-sm font-medium text-gray-700 mb-2">
                    Diagnóstico o Problemas Clínicos
                  </label>
                  <textarea
                    id="diagnostico_o_problemas_clinicos"
                    name="diagnostico_o_problemas_clinicos"
                    value={data.diagnostico_o_problemas_clinicos}
                    onChange={(e) => setData('diagnostico_o_problemas_clinicos', e.target.value)}
                    placeholder="Diagnósticos principales..."
                    rows={3}
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    autoComplete="off"
                  />
                  {errors.diagnostico_o_problemas_clinicos && (
                    <p className="text-red-500 text-sm mt-1">{errors.diagnostico_o_problemas_clinicos}</p>
                  )}
                </div>

                {/* Plan de Estudio */}
                <div className="flex flex-col">
                  <label htmlFor="plan_de_estudio" className="block text-sm font-medium text-gray-700 mb-2">
                    Plan de Estudio
                  </label>
                  <textarea
                    id="plan_de_estudio"
                    name="plan_de_estudio"
                    value={data.plan_de_estudio}
                    onChange={(e) => setData('plan_de_estudio', e.target.value)}
                    placeholder="Plan de estudios adicionales..."
                    rows={3}
                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    autoComplete="off"
                  />
                  {errors.plan_de_estudio && (
                    <p className="text-red-500 text-sm mt-1">{errors.plan_de_estudio}</p>
                  )}
                </div>
                  {/* Tratamiento y Pronóstico */}
                <div className="flex flex-col">
                  <label htmlFor="tratamiento_y_pronostico" className="block text-sm font-medium text-gray-700 mb-2">
                    Tratamiento y Pronóstico
                  </label>
                <textarea
                  id="tratamiento_y_pronostico"
                  name="tratamiento_y_pronostico"
                  value={data.tratamiento_y_pronostico}
                  onChange={(e) => setData('tratamiento_y_pronostico', e.target.value)}
                  placeholder="Tratamiento recomendado y pronóstico..."
                  rows={4}
                  className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                  autoComplete="off"
                />
                {errors.tratamiento_y_pronostico && (
                  <p className="text-red-500 text-sm mt-1">{errors.tratamiento_y_pronostico}</p>
                )}
              </div>
            </div>

            <div className="flex justify-end space-x-4 pt-4">
              <button
                type="submit"
                disabled={processing}
                className="px-6 py-3 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed transition"
                style={{ backgroundColor: '#1B1C38' }}
              >
                {processing ? 'Creando...' : 'Crear Interconsulta'}
              </button>
            </div>
          </div>
        </form>
      </div>
      </MainLayout>
      );
  };
  export default CreateInterconsulta;