import React, { useEffect } from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import InputText from '@/components/ui/input-text';
import FormLayout from '@/components/form-layout';
import { Preoperatoria, Paciente, Estancia } from '@/types';
import { route } from 'ziggy-js';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';

interface Props {
  preoperatoria: Preoperatoria;
  paciente: Paciente;
  estancia: Estancia;
}

interface PreoperatoriaFormData {
  fecha_cirugia: string;
  diagnostico_preoperatorio: string;
  tipo_intervencion_quirurgica: string;
  plan_quirurgico: string;
  riesgo_quirurgico: string;
  observaciones_riesgo: string;
  cuidados_plan_preoperatorios: string;
  pronostico: string;
}

const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;
const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;

const EditPreoperatoria: React.FC<Props> = ({ preoperatoria, paciente, estancia }) => {
  // Intentar separar observaciones si ya existen en el texto de riesgo
  const extractObservaciones = (riesgo: string) => {
    const parts = riesgo?.split(' | Observaciones: ');
    return parts?.[1] || '';
  };

  const { data, setData, put, processing, errors } = useForm<PreoperatoriaFormData>({
    fecha_cirugia: preoperatoria.fecha_cirugia || '',
    diagnostico_preoperatorio: preoperatoria.diagnostico_preoperatorio || '',
    tipo_intervencion_quirurgica: preoperatoria.tipo_intervencion_quirurgica || '',
    plan_quirurgico: preoperatoria.plan_quirurgico || '',
    riesgo_quirurgico: preoperatoria.riesgo_quirurgico || '',
    observaciones_riesgo: extractObservaciones(preoperatoria.riesgo_quirurgico || ''),
    cuidados_plan_preoperatorios: preoperatoria.cuidados_plan_preoperatorios || '',
    pronostico: preoperatoria.pronostico || '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    put(
      route('preoperatorias.edit', {
        paciente: paciente.id,
        estancia: estancia.id,
        preoperatoria: preoperatoria.id,
      }),
    );
  };

  return (
    <>
      <PacienteCard paciente={paciente} estancia={estancia} />
      <Head title={`Editar Valoración Preoperatoria #${preoperatoria.id}`} />

      <FormLayout
        title="Editar Valoración Preoperatoria"
        onSubmit={handleSubmit}
        actions={
          <PrimaryButton type="submit" disabled={processing}>
            {processing ? 'Guardando...' : 'Guardar Cambios'}
          </PrimaryButton>
        }
      >
        {/* Fecha de cirugía */}
        <InputText
          id="fecha_cirugia"
          name="fecha_cirugia"
          label="Fecha de Cirugía"
          type="date"
          value={data.fecha_cirugia}
          onChange={(e) => setData('fecha_cirugia', e.target.value)}
          error={errors.fecha_cirugia}
        />

        {/* Diagnóstico Preoperatorio */}
        <div className="col-span-full md:col-span-1">
          <label htmlFor="diagnostico_preoperatorio" className={labelClasses}>
            Diagnóstico Preoperatorio
          </label>
          <textarea
            id="diagnostico_preoperatorio"
            name="diagnostico_preoperatorio"
            value={data.diagnostico_preoperatorio}
            onChange={(e) => setData('diagnostico_preoperatorio', e.target.value)}
            className={textAreaClasses}
            rows={3}
          />
        </div>

        {/* Tipo de intervención */}
        <InputText
          id="tipo_intervencion_quirurgica"
          name="tipo_intervencion_quirurgica"
          label="Tipo de Intervención Quirúrgica"
          value={data.tipo_intervencion_quirurgica}
          onChange={(e) => setData('tipo_intervencion_quirurgica', e.target.value)}
          error={errors.tipo_intervencion_quirurgica}
        />

        {/* Plan quirúrgico */}
        <div className="col-span-full md:col-span-1">
          <label htmlFor="plan_quirurgico" className={labelClasses}>
            Plan Quirúrgico
          </label>
          <textarea
            id="plan_quirurgico"
            name="plan_quirurgico"
            value={data.plan_quirurgico}
            onChange={(e) => setData('plan_quirurgico', e.target.value)}
            rows={3}
            className={textAreaClasses}
          />
        </div>

        {/* Riesgo quirúrgico */}
        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">
          Riesgo Quirúrgico
        </h2>

        <div className="col-span-full">
          <div className="overflow-x-auto rounded-lg shadow-sm border border-gray-300">
            <table className="min-w-full text-sm text-left text-gray-700">
              <thead className="bg-[#2a2b56] text-white">
                <tr>
                  <th className="px-4 py-2">Nivel</th>
                  <th className="px-4 py-2">Descripción</th>
                </tr>
              </thead>
              <tbody>
                {[
                  { nivel: 'I', descripcion: 'Paciente sano sin patología.' },
                  { nivel: 'II', descripcion: 'Paciente con enfermedad sistémica compensada.' },
                  { nivel: 'III', descripcion: 'Paciente con enfermedad sistémica descompensada.' },
                  {
                    nivel: 'IV',
                    descripcion: 'Paciente con enfermedad sistémica descompensada e incapacitante.',
                  },
                  {
                    nivel: 'V',
                    descripcion:
                      'Paciente con riesgo de fallecer dentro de las 24 hrs posteriores a la valoración, se opere o no.',
                  },
                ].map((item) => (
                  <tr
                    key={item.nivel}
                    className={`cursor-pointer transition ${
                      data.riesgo_quirurgico?.startsWith(item.nivel)
                        ? 'bg-indigo-100 border-l-4 border-[#2a2b56]'
                        : 'hover:bg-gray-100'
                    }`}
                    onClick={() =>
                      setData(
                        'riesgo_quirurgico',
                        `${item.nivel} - ${item.descripcion}${
                          data.observaciones_riesgo
                            ? ' | Observaciones: ' + data.observaciones_riesgo
                            : ''
                        }`,
                      )
                    }
                  >
                    <td className="px-4 py-2 font-semibold">{item.nivel}</td>
                    <td className="px-4 py-2">{item.descripcion}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>

          {/* Campo Observaciones */}
          <div className="mt-4">
            <label htmlFor="observaciones_riesgo" className={labelClasses}>
              Observaciones del Riesgo Quirúrgico
            </label>
            <textarea
              id="observaciones_riesgo"
              name="observaciones_riesgo"
              value={data.observaciones_riesgo}
              onChange={(e) => {
                setData('observaciones_riesgo', e.target.value);
                if (data.riesgo_quirurgico) {
                  const base = data.riesgo_quirurgico.split(' | Observaciones: ')[0];
                  setData('riesgo_quirurgico', `${base} | Observaciones: ${e.target.value}`);
                }
              }}
              rows={3}
              placeholder="Agregue observaciones relevantes al riesgo quirúrgico..."
              className={textAreaClasses}
            />
          </div>

          {data.riesgo_quirurgico && (
            <p className="mt-2 text-sm text-gray-700">
              <span className="font-semibold">Seleccionado:</span> {data.riesgo_quirurgico}
            </p>
          )}
        </div>

        {/* Cuidados y plan preoperatorios */}
        <div className="col-span-full md:col-span-1">
          <label htmlFor="cuidados_plan_preoperatorios" className={labelClasses}>
            Cuidados y Plan Preoperatorios
          </label>
          <textarea
            id="cuidados_plan_preoperatorios"
            name="cuidados_plan_preoperatorios"
            value={data.cuidados_plan_preoperatorios}
            onChange={(e) => setData('cuidados_plan_preoperatorios', e.target.value)}
            rows={3}
            className={textAreaClasses}
          />
        </div>

        {/* Pronóstico */}
        <div className="col-span-full md:col-span-1">
          <label htmlFor="pronostico" className={labelClasses}>
            Pronóstico
          </label>
          <textarea
            id="pronostico"
            name="pronostico"
            value={data.pronostico}
            onChange={(e) => setData('pronostico', e.target.value)}
            rows={3}
            className={textAreaClasses}
          />
        </div>
      </FormLayout>
    </>
  );
};

EditPreoperatoria.layout = (page: React.ReactElement) => (
  <MainLayout pageTitle="Editar Valoración Preoperatoria" children={page} />
);

export default EditPreoperatoria;
