import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import PrimaryButton from '@/components/ui/primary-button';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente } from '@/types';
import PacienteCard from '@/components/paciente-card';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
};

const CreateNotaEgreso: React.FC<Props> = ({ paciente, estancia }) => {
  const { data, setData, post, processing, errors } = useForm({
  motivo_egreso: '',             
  motivo_egreso_otro: '',  
  diagnosticos_finales: '',  
  resumen_evolucion_estado_actual: '',
  manejo_durante_estancia: '',
  problemas_pendientes: '',
  plan_manejo_tratamiento: '',
  recomendaciones: '',
  factores_riesgo: '',
  pronostico: '',
  defuncion: '',
});

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    post(
      route('pacientes.estancias.notasegresos.store', {
        paciente: paciente.id,
        estancia: estancia.id,
      })
    );
  };

  const textAreaClasses =
    'w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition';
  const labelClasses = 'block text-sm font-medium text-gray-700 mb-1';

  return (
    <MainLayout 
      pageTitle={`Creación de nota de egreso`}
      link="estancias.show"
      
      linkParams={estancia.id} 
      
    >
    
    
      <PacienteCard paciente={paciente} estancia={estancia} />

      <Head title="Crear Nota de Egreso" />

      <FormLayout
        title="Registro de Nota de Egreso"
        onSubmit={handleSubmit}
        actions={
          <PrimaryButton type="submit" disabled={processing}>
            {processing ? 'Creando...' : 'Crear Nota de Egreso'}
          </PrimaryButton>
        }
      >
      {/* Motivo de egreso */}
        <div className="mb-4">
        <label htmlFor="motivo_egreso" className={labelClasses}>
            Motivo de egreso
        </label>

        <select
            id="motivo_egreso"
            className="w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56]"
            value={data.motivo_egreso}
            onChange={(e) => setData('motivo_egreso', e.target.value)}
        >
            <option value="">Seleccione una opción</option>
            <option value="curacion">Curación</option>
            <option value="mejoria">Mejoría</option>
            <option value="alta_voluntaria">Alta voluntaria</option>
            <option value="defuncion">Defunción</option>
            <option value="otro">Otros</option>
        </select>

        {errors.motivo_egreso && (
            <div className="text-red-500 text-sm">{errors.motivo_egreso}</div>
        )}
        </div>

        {/* Campo adicional si selecciona "otro" */}
        {data.motivo_egreso === 'otro' && (
        <div className="mb-4">
            <label htmlFor="motivo_egreso_otro" className={labelClasses}>
            Especifique otro motivo
            </label>
            <textarea
            id="motivo_egreso_otro"
            className={textAreaClasses}
            value={data.motivo_egreso_otro || ''}
            onChange={(e) => setData('motivo_egreso_otro', e.target.value)}
            placeholder="Escriba el motivo de egreso"
            rows={3}
            autoComplete="off"
            />
            {errors.motivo_egreso_otro && (
            <div className="text-red-500 text-sm">{errors.motivo_egreso_otro}</div>
            )}
        </div>
        )}

        {/* Diagnósticos finales */}
        <div className="mb-4">
          <label htmlFor="diagnosticos_finales" className={labelClasses}>  
            Diagnósticos finales
          </label>
          <textarea
            id="diagnosticos_finales"  
            className={textAreaClasses}
            value={data.diagnosticos_finales}  
            onChange={(e) => setData('diagnosticos_finales', e.target.value)}  
            placeholder="Anote los diagnósticos finales"
            rows={4}
            autoComplete="off"
          />
          {errors.diagnosticos_finales && (  
            <div className="text-red-500 text-sm">
              {errors.diagnosticos_finales}  
            </div>
          )}
        </div>

        {/* Resumen de evolución y estado actual */}
        <div className="mb-4">
          <label
            htmlFor="resumen_evolucion_estado_actual"
            className={labelClasses}
          >
            Resumen de la evolución y estado actual
          </label>
          <textarea
            id="resumen_evolucion_estado_actual"
            className={textAreaClasses}
            value={data.resumen_evolucion_estado_actual}
            onChange={(e) =>
              setData('resumen_evolucion_estado_actual', e.target.value)
            }
            placeholder="Resuma la evolución clínica y el estado actual al egreso"
            rows={4}
            autoComplete="off"
          />
          {errors.resumen_evolucion_estado_actual && (
            <div className="text-red-500 text-sm">
              {errors.resumen_evolucion_estado_actual}
            </div>
          )}
        </div>

        {/* Manejo durante la estancia */}
        <div className="mb-4">
          <label
            htmlFor="manejo_durante_estancia"
            className={labelClasses}
          >
            Manejo durante la estancia
          </label>
          <textarea
            id="manejo_durante_estancia"
            className={textAreaClasses}
            value={data.manejo_durante_estancia}
            onChange={(e) =>
              setData('manejo_durante_estancia', e.target.value)
            }
            placeholder="Describa el manejo terapéutico durante la estancia"
            rows={4}
            autoComplete="off"
          />
          {errors.manejo_durante_estancia && (
            <div className="text-red-500 text-sm">
              {errors.manejo_durante_estancia}
            </div>
          )}
        </div>

        {/* Problemas pendientes */}
        <div className="mb-4">
          <label htmlFor="problemas_pendientes" className={labelClasses}>
            Problemas pendientes
          </label>
          <textarea
            id="problemas_pendientes"
            className={textAreaClasses}
            value={data.problemas_pendientes}
            onChange={(e) =>
              setData('problemas_pendientes', e.target.value)
            }
            placeholder="Indique los problemas que quedan pendientes al egreso"
            rows={4}
            autoComplete="off"
          />
          {errors.problemas_pendientes && (
            <div className="text-red-500 text-sm">
              {errors.problemas_pendientes}
            </div>
          )}
        </div>

        {/* Plan de manejo y tratamiento */}
        <div className="mb-4">
          <label
            htmlFor="plan_manejo_tratamiento"
            className={labelClasses}
          >
            Plan de manejo y tratamiento
          </label>
          <textarea
            id="plan_manejo_tratamiento"
            className={textAreaClasses}
            value={data.plan_manejo_tratamiento}
            onChange={(e) =>
              setData('plan_manejo_tratamiento', e.target.value)
            }
            placeholder="Describa el plan de manejo y tratamiento posterior"
            rows={4}
            autoComplete="off"
          />
          {errors.plan_manejo_tratamiento && (
            <div className="text-red-500 text-sm">
              {errors.plan_manejo_tratamiento}
            </div>
          )}
        </div>

        {/* Recomendaciones */}
        <div className="mb-4">
          <label htmlFor="recomendaciones" className={labelClasses}>
            Recomendaciones
          </label>
          <textarea
            id="recomendaciones"
            className={textAreaClasses}
            value={data.recomendaciones}
            onChange={(e) =>
              setData('recomendaciones', e.target.value)
            }
            placeholder="Anote recomendaciones al paciente y/o familiares"
            rows={4}
            autoComplete="off"
          />
          {errors.recomendaciones && (
            <div className="text-red-500 text-sm">
              {errors.recomendaciones}
            </div>
          )}
        </div>

        {/* Factores de riesgo */}
        <div className="mb-4">
          <label htmlFor="factores_riesgo" className={labelClasses}>
            Factores de riesgo
          </label>
          <textarea
            id="factores_riesgo"
            className={textAreaClasses}
            value={data.factores_riesgo}
            onChange={(e) =>
              setData('factores_riesgo', e.target.value)
            }
            placeholder="Describa factores de riesgo relevantes"
            rows={4}
            autoComplete="off"
          />
          {errors.factores_riesgo && (
            <div className="text-red-500 text-sm">
              {errors.factores_riesgo}
            </div>
          )}
        </div>

        {/* Pronóstico */}
        <div className="mb-4">
          <label htmlFor="pronostico" className={labelClasses}>
            Pronóstico
          </label>
          <textarea
            id="pronostico"
            className={textAreaClasses}
            value={data.pronostico}
            onChange={(e) => setData('pronostico', e.target.value)}
            placeholder="Describa el pronóstico al egreso"
            rows={4}
            autoComplete="off"
          />
          {errors.pronostico && (
            <div className="text-red-500 text-sm">{errors.pronostico}</div>
          )}
        </div>

        {/* Defunción */}
        <div className="mb-4">
          <label htmlFor="defuncion" className={labelClasses}>
            Defunción (en su caso)
          </label>
          <textarea
            id="defuncion"
            className={textAreaClasses}
            value={data.defuncion}
            onChange={(e) => setData('defuncion', e.target.value)}
            placeholder="Registre detalles en caso de defunción (fecha, causa, etc.)"
            rows={4}
            autoComplete="off"
          />
          {errors.defuncion && (
            <div className="text-red-500 text-sm">{errors.defuncion}</div>
          )}
        </div>
      </FormLayout>
    </MainLayout>
  );
};

export default CreateNotaEgreso;
