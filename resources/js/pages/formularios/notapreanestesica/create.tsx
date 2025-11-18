import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';
import Generalidades from '@/components/forms/generalidades';
import { Paciente, Estancia } from '@/types';
import { route } from 'ziggy-js';

interface Props {
  paciente: Paciente;
  estancia: Estancia;
}

interface NotaPreAnestesicaFormData {
  ta?: string;
  fc?: number | string;
  fr?: number | string;
  peso?: number | string;
  talla?: number | string;
  temp?: number | string;
  resumen_del_interrogatorio?: string;
  exploracion_fisica?: string;
  diagnostico_o_problemas_clinicos?: string;
  plan_de_estudio?: string;
  pronostico?: string;
  plan_estudios_tratamiento?: string;
  evaluacion_clinica?: string;
  plan_anestesico?: string;
  valoracion_riesgos?: string;
  indicaciones_recomendaciones?: string;
}

const CreateNotaPreanestesica: React.FC<Props> = ({ paciente, estancia }) => {
  const { data, setData, errors, post, processing } =
    useForm<NotaPreAnestesicaFormData>({
      ta: '',
      fc: '',
      fr: '',
      peso: '',
      talla: '',
      temp: '',
      resumen_del_interrogatorio: '',
      exploracion_fisica: '',
      diagnostico_o_problemas_clinicos: '',
      plan_de_estudio: '',
      pronostico: '',
      plan_estudios_tratamiento: '',
      evaluacion_clinica: '',
      plan_anestesico: '',
      valoracion_riesgos: '',
      indicaciones_recomendaciones: '',
    });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    post(
      route('pacientes.estancias.notaspreanestesicas.store', {
        paciente: paciente.id,
        estancia: estancia.id,
      })
    );
  };

  const labelClasses =
    'block text-sm font-medium text-gray-700 mb-1';
  const textAreaClasses =
    'w-full rounded-md shadow-sm border px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500';

  return (
    <><MainLayout>
        
          <PacienteCard paciente={paciente} estancia={estancia} />
       
      <Head title="Nota Preanestésica" />
    
      <FormLayout
        title="Nota Preanestésica"
        onSubmit={handleSubmit}
        actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Creando...': 'Crear nota pre-anestesica'}</PrimaryButton>} 
        >
        

        
          {/* Generalidades (signos vitales + exploración) */}
          <Generalidades data={data} setData={setData} errors={errors} />

          {/* Campos específicos de la Nota Preanestésica */}
          <div className="col-span-full">
            <label
              htmlFor="plan_estudios_tratamiento"
              className={labelClasses}
            >
             Plan de estudio y/o Tratamiento (indicaciones médicas, vía, dosis, periodicidad) 
            </label>
            <textarea
              id="plan_estudios_tratamiento"
              name="plan_estudios_tratamiento"
              value={data.plan_estudios_tratamiento ?? ''}
              onChange={(e) =>
                setData('plan_estudios_tratamiento', e.target.value)
              }
              placeholder="Describa el plan de estudios y tratamiento..."
              rows={3}
              className={`${textAreaClasses} ${
                errors.plan_estudios_tratamiento
                  ? 'border-red-500'
                  : 'border-gray-600'
              }`}
            />
            {errors.plan_estudios_tratamiento && (
              <p className="mt-1 text-xs text-red-500">
                {errors.plan_estudios_tratamiento}
              </p>
            )}
          </div>

          <div className="col-span-full">
            <label htmlFor="evaluacion_clinica" className={labelClasses}>
              Evaluación clínica del paciente
            </label>
            <textarea
              id="evaluacion_clinica"
              name="evaluacion_clinica"
              value={data.evaluacion_clinica ?? ''}
              onChange={(e) =>
                setData('evaluacion_clinica', e.target.value)
              }
              placeholder="Describa la evaluación clínica preanestésica..."
              rows={3}
              className={`${textAreaClasses} ${
                errors.evaluacion_clinica
                  ? 'border-red-500'
                  : 'border-gray-600'
              }`}
            />
            {errors.evaluacion_clinica && (
              <p className="mt-1 text-xs text-red-500">
                {errors.evaluacion_clinica}
              </p>
            )}
          </div>

          <div className="col-span-full">
            <label htmlFor="plan_anestesico" className={labelClasses}>
              Plan anestésico, de acuerdo con las condiciones del paciente y la intervención quirúrgica planeada
            </label>
            <textarea
              id="plan_anestesico"
              name="plan_anestesico"
              value={data.plan_anestesico ?? ''}
              onChange={(e) =>
                setData('plan_anestesico', e.target.value)
              }
              placeholder="Describa el plan anestésico propuesto..."
              rows={3}
              className={`${textAreaClasses} ${
                errors.plan_anestesico
                  ? 'border-red-500'
                  : 'border-gray-600'
              }`}
            />
            {errors.plan_anestesico && (
              <p className="mt-1 text-xs text-red-500">
                {errors.plan_anestesico}
              </p>
            )}
          </div>

          <div className="col-span-full">
            <label htmlFor="valoracion_riesgos" className={labelClasses}>
              Valoración de riesgos
            </label>
            <textarea
              id="valoracion_riesgos"
              name="valoracion_riesgos"
              value={data.valoracion_riesgos ?? ''}
              onChange={(e) =>
                setData('valoracion_riesgos', e.target.value)
              }
              placeholder="Describa la valoración de riesgos anestésicos..."
              rows={3}
              className={`${textAreaClasses} ${
                errors.valoracion_riesgos
                  ? 'border-red-500'
                  : 'border-gray-600'
              }`}
            />
            {errors.valoracion_riesgos && (
              <p className="mt-1 text-xs text-red-500">
                {errors.valoracion_riesgos}
              </p>
            )}
          </div>

          <div className="col-span-full">
            <label
              htmlFor="indicaciones_recomendaciones"
              className={labelClasses}
            >
              Indicaciones y recomendaciones del servicio de anestesiología.
            </label>
            <textarea
              id="indicaciones_recomendaciones"
              name="indicaciones_recomendaciones"
              value={data.indicaciones_recomendaciones ?? ''}
              onChange={(e) =>
                setData('indicaciones_recomendaciones', e.target.value)
              }
              placeholder="Indicaciones y recomendaciones al paciente..."
              rows={3}
              className={`${textAreaClasses} ${
                errors.indicaciones_recomendaciones
                  ? 'border-red-500'
                  : 'border-gray-600'
              }`}
            />
            {errors.indicaciones_recomendaciones && (
              <p className="mt-1 text-xs text-red-500">
                {errors.indicaciones_recomendaciones}
              </p>
            )}
          </div>

          
        
      </FormLayout>
     </MainLayout>
    </>
  );
};

export default CreateNotaPreanestesica;
