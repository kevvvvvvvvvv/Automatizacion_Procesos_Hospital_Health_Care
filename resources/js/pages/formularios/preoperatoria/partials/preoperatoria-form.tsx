import React from 'react';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import { useForm } from '@inertiajs/react';
import { Estancia, Paciente, Preoperatoria } from '@/types';
import Generalidades from '@/components/forms/generalidades';
// Asegúrate de importar tu componente InputTextArea
import InputTextArea from '@/components/ui/input-text-area';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  preoperatoria: Preoperatoria;
  onSubmit: (form: any) => void;
  submitLabel?: string;
};

export const PreOperatoriaForm = ({
  paciente,
  estancia,
  preoperatoria,
  onSubmit,
  submitLabel = "guardar"
}: Props) => {
  
  const form = useForm({
    ta: preoperatoria?.ta || '',
    fc: preoperatoria?.fc || '',
    fr: preoperatoria?.fr || '',
    peso: preoperatoria?.peso || '',
    talla: preoperatoria?.talla || '',
    temp: preoperatoria?.temp || '',
    resultado_estudios: preoperatoria?.resultado_estudios || '',
    resumen_del_interrogatorio: preoperatoria?.resumen_del_interrogatorio || '',
    exploracion_fisica: preoperatoria?.exploracion_fisica || '',
    diagnostico_o_problemas_clinicos: preoperatoria?.diagnostico_o_problemas_clinicos || '',
    plan_de_estudio: preoperatoria?.plan_de_estudio || '',
    pronostico: preoperatoria?.pronostico || '',
    tratamiento: preoperatoria?.tratamiento || '',
    diagnostico_preoperatorio: preoperatoria?.diagnostico_preoperatorio || '',
    observaciones_riesgo: preoperatoria?.observaciones_riesgo || '',
    fecha_cirugia: preoperatoria?.fecha_cirugia || '',
    plan_quirurgico: preoperatoria?.plan_quirurgico || '',
    tipo_intervencion_quirurgica: preoperatoria?.tipo_intervencion_quirurgica || '',
    riesgo_quirurgico: preoperatoria?.riesgo_quirurgico || '',
    cuidados_plan_preoperatorios: preoperatoria?.cuidados_plan_preoperatorios || '',
  });

  const { data, setData, processing, errors } = form;

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onSubmit(form);
  };

  const handleNivelSelect = (nivel: string, descripcion: string) => {
    const obsActuales = data.observaciones_riesgo ? ` | Observaciones: ${data.observaciones_riesgo}` : '';
    setData('riesgo_quirurgico', `${nivel} - ${descripcion}${obsActuales}`);
  };

  const handleObservacionesChange = (val: string) => {
    setData((prevData) => {
      const nivelBase = prevData.riesgo_quirurgico ? prevData.riesgo_quirurgico.split(' | Observaciones:')[0] : '';
      
      return {
        ...prevData,
        observaciones_riesgo: val,

        riesgo_quirurgico: nivelBase ? `${nivelBase} | Observaciones: ${val}` : ''
      };
    });
  };

  return (
    <FormLayout
      title="Registrar Valoración Preoperatoria"
      onSubmit={handleSubmit}
      actions={
        <PrimaryButton type="submit" disabled={processing}>
          {processing ? 'Guardando...' : submitLabel}
        </PrimaryButton>
      }
    >

      <h2 className="text-xl font-semibold text-gray-800 mt-2 mb-4 col-span-full">
        Datos Preoperatorios
      </h2>

      <InputText
        id="fecha_cirugia"
        label="Fecha de Cirugía"
        name="fecha_cirugia"
        type="date"
        value={data.fecha_cirugia}
        onChange={(e) => setData('fecha_cirugia', e.target.value)}
        error={errors.fecha_cirugia}
      />

      <InputTextArea
        label="Diagnóstico Preoperatorio"
        id="diagnostico_preoperatorio"
        name="diagnostico_preoperatorio"
        value={data.diagnostico_preoperatorio}
        onChange={(e) => setData('diagnostico_preoperatorio', e.target.value)}
        placeholder="Describa el diagnóstico preoperatorio..."
        rows={3}
        className="col-span-full md:col-span-1"
        error={errors.diagnostico_preoperatorio}
      />

      <InputTextArea
        label="Plan Quirúrgico"
        id="plan_quirurgico"
        name="plan_quirurgico"
        value={data.plan_quirurgico}
        onChange={(e) => setData('plan_quirurgico', e.target.value)}
        placeholder="Describa el plan quirúrgico..."
        rows={3}
        className="col-span-full md:col-span-1"
        error={errors.plan_quirurgico}
      />

      <InputText
        id="tipo_intervencion_quirurgica"
        label="Tipo de Intervención Quirúrgica"
        name="tipo_intervencion_quirurgica"
        value={data.tipo_intervencion_quirurgica}
        onChange={(e) => setData('tipo_intervencion_quirurgica', e.target.value)}
        placeholder="Ej: Electiva / Urgente / Programada"
        error={errors.tipo_intervencion_quirurgica}
      />

      <Generalidades data={data} setData={setData} errors={errors} />


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
                { nivel: 'IV', descripcion: 'Paciente con enfermedad sistémica descompensada e incapacitante.' },
                { nivel: 'V', descripcion: 'Paciente con riesgo de fallecer dentro de las 24 hrs posteriores a la valoración, se opere o no.' },
              ].map((item) => (
                <tr
                  key={item.nivel}
                  className={`cursor-pointer transition ${
                    data.riesgo_quirurgico?.startsWith(`${item.nivel} -`)
                      ? 'bg-indigo-100 border-l-4 border-[#2a2b56]'
                      : 'hover:bg-gray-100'
                  }`}
                  onClick={() => handleNivelSelect(item.nivel, item.descripcion)}
                >
                  <td className="px-4 py-2 font-semibold">{item.nivel}</td>
                  <td className="px-4 py-2">{item.descripcion}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {errors.riesgo_quirurgico && (
          <p className="mt-2 text-xs text-red-500">{errors.riesgo_quirurgico}</p>
        )}

        <div className="mt-4">
          <InputTextArea
            label="Observaciones del Riesgo Quirúrgico"
            id="observaciones_riesgo"
            name="observaciones_riesgo"
            value={data.observaciones_riesgo || ''}
            onChange={(e) => handleObservacionesChange(e.target.value)}
            placeholder="Agregue observaciones relevantes al riesgo quirúrgico..."
            rows={3}

          />
        </div>
        {data.riesgo_quirurgico && (
          <p className="mt-3 text-sm text-gray-700">
            <span className="font-semibold">Seleccionado:</span> {data.riesgo_quirurgico}
          </p>
        )}
      </div>

      <InputTextArea
        label="Cuidados y Plan Preoperatorios"
        id="cuidados_plan_preoperatorios"
        name="cuidados_plan_preoperatorios"
        value={data.cuidados_plan_preoperatorios}
        onChange={(e) => setData('cuidados_plan_preoperatorios', e.target.value)}
        placeholder="Indique cuidados y plan preoperatorio..."
        rows={3}
        className="col-span-full md:col-span-1"
        error={errors.cuidados_plan_preoperatorios}
      />
    </FormLayout>
  );
};