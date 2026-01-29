import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';
import Generalidades from '@/components/forms/generalidades';
import { Paciente, Estancia, NotaPreAnestesica } from '@/types';
import { route } from 'ziggy-js';
import InputTextArea from '@/components/ui/input-text-area';

interface Props {
  paciente: Paciente;
  estancia: Estancia;
  onSubmit: (form: any ) => void;
  preanestesica : NotaPreAnestesica;
  submitLabel?: string;
}
export const Preanestesicaform = ({
  onSubmit,
  preanestesica,
  submitLabel,
} : Props) => {
  const form = useForm ({
    ta: preanestesica?.ta || '',
        fc: preanestesica?.fc || '',
        fr: preanestesica?.fr || '',
        peso: preanestesica?.peso || '',
        talla: preanestesica?.talla || '',
        temp: preanestesica?.temp || '',
         resultado_estudios: preanestesica?.resultado_estudios || '',
        resumen_del_interrogatorio: preanestesica?.resumen_del_interrogatorio ||  '',
        exploracion_fisica: preanestesica?.exploracion_fisica || '',
        diagnostico_o_problemas_clinicos: preanestesica?.diagnostico_o_problemas_clinicos || '',
        plan_de_estudio: preanestesica?.plan_de_estudio || '',
        pronostico: preanestesica?.pronostico || '',
        tratamiento: preanestesica?.tratamiento || '', 
        plan_estudios_tratamiento: preanestesica?.plan_estudios_tratamiento || '',
        evaluacion_clinica: preanestesica?.evaluacion_clinica ||  '',
        plan_anestesico: preanestesica?.plan_anestesico || '',
        valoracion_riesgos: preanestesica?.valoracion_riesgos || '',
        indicaciones_recomendaciones: preanestesica?.indicaciones_recomendaciones || '',
  });
  const {data, setData, processing, errors} = form;
    const handleSubmit = (e: React.FormEvent) =>{
      e.preventDefault();
      onSubmit(form);
      }

    return(
      <>
      <FormLayout
          title="Nota Preanestésica"
          onSubmit={handleSubmit}
          actions={
            <PrimaryButton type="submit" disabled={processing}>
              {processing ? 'Creando...' : 'Crear nota pre-anestésica'}
            </PrimaryButton>
          }
        >
          

          {/* Generalidades (signos vitales, resumen, etc.) */}
          <Generalidades data={data} setData={setData} errors={errors} />

          {/* Plan de estudios / tratamiento */}
          <InputTextArea
              label="Plan de estudio y/o tratamiento (indicaciones médicas, vía, dosis, periodicidad)"
              id="plan_estudios_tratamiento"
              name="plan_estudios_tratamiento"
              value={data.plan_estudios_tratamiento ?? ''}
              onChange={(e) => setData('plan_estudios_tratamiento', e.target.value)}
              placeholder="Describa el plan de estudios y tratamiento..."
              rows={3}
              className="col-span-full"
              error={errors.plan_estudios_tratamiento}
          />

          {/* Evaluación clínica */}
          <InputTextArea
              label="Evaluación clínica del paciente"
              id="evaluacion_clinica"
              name="evaluacion_clinica"
              value={data.evaluacion_clinica ?? ''}
              onChange={(e) => setData('evaluacion_clinica', e.target.value)}
              placeholder="Describa la evaluación clínica preanestésica..."
              rows={3}
              className="col-span-full"
              error={errors.evaluacion_clinica}
          />

          {/* Plan anestésico */}
          <InputTextArea
              label="Plan anestésico, de acuerdo con las condiciones del paciente y la intervención quirúrgica planeada"
              id="plan_anestesico"
              name="plan_anestesico"
              value={data.plan_anestesico ?? ''}
              onChange={(e) => setData('plan_anestesico', e.target.value)}
              placeholder="Describa el plan anestésico propuesto..."
              rows={3}
              className="col-span-full"
              error={errors.plan_anestesico}
          />

          {/* Valoración de riesgos */}
          <InputTextArea
              label="Valoración de riesgos"
              id="valoracion_riesgos"
              name="valoracion_riesgos"
              value={data.valoracion_riesgos ?? ''}
              onChange={(e) => setData('valoracion_riesgos', e.target.value)}
              placeholder="Describa la valoración de riesgos anestésicos..."
              rows={3}
              className="col-span-full"
              error={errors.valoracion_riesgos}
          />

          {/* Indicaciones y recomendaciones */}
          <InputTextArea
              label="Indicaciones y recomendaciones del servicio de anestesiología"
              id="indicaciones_recomendaciones"
              name="indicaciones_recomendaciones"
              value={data.indicaciones_recomendaciones ?? ''}
              onChange={(e) => setData('indicaciones_recomendaciones', e.target.value)}
              placeholder="Indicaciones y recomendaciones al paciente..."
              rows={3}
              className="col-span-full"
              error={errors.indicaciones_recomendaciones}
          />
        </FormLayout>
      </>
    )
}