import React from 'react';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import { useForm, Head } from '@inertiajs/react';;
import { Estancia, Paciente, Preoperatoria} from '@/types';

import Generalidades from '@/components/forms/generalidades';


type Props = {
  paciente: Paciente;
  estancia: Estancia;
  preoperatoria: Preoperatoria;
  onSubmit:  (form:any) => void;
  submitLabel?: string;
};

export const PreOperatoriaForm = ({
    paciente,
    estancia,
    preoperatoria,
    onSubmit,
    submitLabel = "guardar"
}:  Props) => {
    const form = useForm({
        ta: preoperatoria?.ta || '',
        fc: preoperatoria?.fc || '',
        fr: preoperatoria?.fr || '' ,
        peso: preoperatoria?.peso || '',
        talla:preoperatoria?.talla || '',
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
        fecha_cirugia: preoperatoria?. fecha_cirugia|| '',
        plan_quirurgico:  preoperatoria?.plan_quirurgico || '',
        tipo_intervencion_quirurgica: preoperatoria?.tipo_intervencion_quirurgica || '',
        riesgo_quirurgico: preoperatoria?.riesgo_quirurgico || '',
        cuidados_plan_preoperatorios: preoperatoria?.cuidados_plan_preoperatorios || '',
    });
     const { data, setData, processing, errors } = form
        const handleSubmit = (e: React.FormEvent) => {
            e.preventDefault();
            onSubmit(form);
        };
   
  const textAreaClasses ='w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition';
  const labelClasses = 'block text-sm font-medium text-gray-700 mb-1';

  return (
     <FormLayout
        title="Registrar Valoración Preoperatoria"
        onSubmit={handleSubmit}
        actions={
          <PrimaryButton type="submit" disabled={processing}>
            {processing ? 'Guardando...' : '  Valoración'}
          </PrimaryButton>
        }
      >
        {/* Diagnóstico preoperatorio */}
        <h2 className="text-xl font-semibold text-gray-800 mt-2 mb-4 col-span-full">
          Datos Preoperatorios
        </h2>
        {/* Fecha de cirugía */}
        <InputText
          id="fecha_cirugia"
          label="Fecha de Cirugía"
          name="fecha_cirugia"
          type="date"
          value={data.fecha_cirugia}
          onChange={(e) => setData('fecha_cirugia', e.target.value)}
          error={errors.fecha_cirugia}
        />
        <div className="col-span-full md:col-span-1">
          <label htmlFor="diagnostico_preoperatorio" className={labelClasses}>
            Diagnóstico Preoperatorio
          </label>
          <textarea
            id="diagnostico_preoperatorio"
            name="diagnostico_preoperatorio"
            value={data.diagnostico_preoperatorio}
            onChange={(e) => setData('diagnostico_preoperatorio', e.target.value)}
            placeholder="Describa el diagnóstico preoperatorio..."
            rows={3}
            className={`${textAreaClasses} ${
              errors.diagnostico_preoperatorio ? 'border-red-500' : 'border-gray-600'
            }`}
            autoComplete="off"
          />
          {errors.diagnostico_preoperatorio && (
            <p className="mt-1 text-xs text-red-500">{errors.diagnostico_preoperatorio}</p>
          )}
        </div>

        

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
            placeholder="Describa el plan quirúrgico..."
            rows={3}
            className={`${textAreaClasses} ${
              errors.plan_quirurgico ? 'border-red-500' : 'border-gray-600'
            }`}
            autoComplete="off"
          />
          {errors.plan_quirurgico && (
            <p className="mt-1 text-xs text-red-500">{errors.plan_quirurgico}</p>
          )}
        </div>

        {/* Tipo de intervención quirúrgica */}
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
                  { nivel: 'IV', descripcion: 'Paciente con enfermedad sistémica descompensada e incapacitante.' },
                  { nivel: 'V', descripcion: 'Paciente con riesgo de fallecer dentro de las 24 hrs posteriores a la valoración, se opere o no.' },
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
                        `${item.nivel} - ${item.descripcion}${data.observaciones_riesgo ? ' | Observaciones: ' + data.observaciones_riesgo : ''}`,
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

          {errors.riesgo_quirurgico && (
            <p className="mt-2 text-xs text-red-500">{errors.riesgo_quirurgico}</p>
          )}
          
          {/* Campo de observaciones */}
          <div className="mt-4">
            <label htmlFor="observaciones_riesgo" className="block text-sm font-medium text-gray-700 mb-1">
              Observaciones del Riesgo Quirúrgico
            </label>
            <textarea
              id="observaciones_riesgo"
              name="observaciones_riesgo"
              rows={3}
              placeholder="Agregue observaciones relevantes al riesgo quirúrgico..."
              className="w-full px-3 py-2 rounded-md shadow-sm border border-gray-600 text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition"
              value={data.observaciones_riesgo || ''}
              onChange={(e) => {
                setData('observaciones_riesgo', e.target.value);
                if (data.riesgo_quirurgico) {
                  const base = data.riesgo_quirurgico.split(' | Observaciones: ')[0];
                  setData('riesgo_quirurgico', `${base} | Observaciones: ${e.target.value}`);
                }
              }}
              autoComplete="off"
            />
          </div>

          {/* Mostrar selección actual */}
          {data.riesgo_quirurgico && (
            <p className="mt-3 text-sm text-gray-700">
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
            placeholder="Indique cuidados y plan preoperatorio..."
            rows={3}
            className={`${textAreaClasses} ${
              errors.cuidados_plan_preoperatorios ? 'border-red-500' : 'border-gray-600'
            }`}
            autoComplete="off"
          />
          {errors.cuidados_plan_preoperatorios && (
            <p className="mt-1 text-xs text-red-500">{errors.cuidados_plan_preoperatorios}</p>
          )}
        </div>

        
      </FormLayout>


  )
}