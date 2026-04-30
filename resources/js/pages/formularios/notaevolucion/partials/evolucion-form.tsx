import React from 'react';
import { useForm } from '@inertiajs/react';
import { CatalogoEstudio, Estancia, MedicamentoAgregado, Paciente, ProductoServicio, notasEvoluciones,  } from '@/types';  ;

import PrimaryButton from '@/components/ui/primary-button';
import FormLayout from '@/components/form-layout';
import TextAreaInput from '@/components/ui/input-text-area';
import Generalidades from '@/components/forms/generalidades';
import TratamientoDietasForm from '@/components/forms/tratamiento-dietas-form';
import TratamientoSolucionesForm from '@/components/forms/tratamiento-soluciones-form';
import TratamientoMedicamentosForm from '@/components/forms/tratamiento-medicamentos-form';
import TratamientoLaboratoriosForm from '@/components/forms/tratamiento-laboratorios-form';
import TratamientoMedidasGeneralesForm from '@/components/forms/tratamiento-medidas-generales-form';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  evolucion? :notasEvoluciones;
  soluciones: ProductoServicio[]; 
  medicamentos: ProductoServicio[]; 
  estudios: CatalogoEstudio [];
  onSubmit: (form:any) => void;
  submitLabel?: string; 
};



export const EvolucionForm =({ 
    onSubmit,
    evolucion,
    soluciones,
    medicamentos,
    estudios,
    submitLabel = 'Guardar'
}: Props) => {
    const form = useForm({
      evolucion_actualizacion: evolucion?.evolucion_actualizacion || '',
      ta: evolucion?.ta || '',
      fc: evolucion?.fc || '',
      fr: evolucion?.fr || '',
      spo2: evolucion?.spo2 || '',
      temp: evolucion?.temp || '',
      peso: evolucion?.peso || '',
      talla: evolucion?.talla || '',
      exploracion_fisica: evolucion?.exploracion_fisica || '',
      resumen_del_interrogatorio: evolucion?.resumen_del_interrogatorio  || '',
      resultados_relevantes: evolucion?.resultados_relevantes || '',
      diagnostico_o_problemas_clinicos: evolucion?.diagnostico_o_problemas_clinicos || '',
      pronostico: evolucion?.pronostico || '',
      resultado_estudios: evolucion?.resultado_estudios || '',
      tratamiento: evolucion?.tratamiento || '',
      plan_de_estudio: evolucion?.plan_de_estudio || '',
      manejo_dieta:  evolucion?.manejo_dieta || '',
      manejo_soluciones:  evolucion?.manejo_soluciones || '',
      manejo_medicamentos:  evolucion?.manejo_medicamentos || '',
      manejo_medidas_generales:  evolucion?.manejo_medidas_generales || '',
      manejo_laboratorios:  evolucion?.manejo_laboratorios || '',

      medicamentos_agregados: evolucion?.medicamentos ? 
        evolucion.medicamentos.map(med => ({
            medicamento_id: med.producto_servicio_id.toString(),
            nombre: med.nombre_medicamento,
            dosis: med.dosis.toString(),
            gramaje: med.gramaje,
            via: med.via_administracion,
            via_label: med.via_administracion,
            duracion: med.duracion_tratamiento.toString(),
            unidad: med.unidad,
            razon_necesaria: false, 
            temp_id: med.id.toString(), 
        })) 
        : [] as MedicamentoAgregado[],
    });

    const { data, setData, processing, errors } = form;
        
        const handleSubmit = (e: React.FormEvent) => {
            e.preventDefault();
            onSubmit(form);
            
        };

  return(
    <FormLayout
        title="Registro de Nota de Evolución"
        onSubmit={handleSubmit}
        actions={
          <PrimaryButton type="submit" disabled={processing}>
            {processing ? 'Guardando...' : submitLabel}
          </PrimaryButton>
        }
      >
        <TextAreaInput
          label = 'Evolución y actualización'
          value = {data.evolucion_actualizacion}
          onChange={(e) => setData('evolucion_actualizacion', e.target.value)}
          rows={4}
          error={errors.evolucion_actualizacion}
        />

        <Generalidades data={data} setData={setData} errors={errors} />

        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">
          Tratamiento e Indicaciones Médicas
        </h2>
        <div>
          <TratamientoDietasForm
          value={data.manejo_dieta}
          onChange={value=>(setData('manejo_dieta',value))}  
        />
        </div>

        <div>
          <TratamientoSolucionesForm
            value={data.manejo_soluciones}
            onChange={(value) => setData('manejo_soluciones', value)}
            soluciones={soluciones}
          />
          {errors.manejo_soluciones && (
            <div className="text-red-500 text-sm">{errors.manejo_soluciones}</div>
          )}
        </div>
        <div>
          <TratamientoMedicamentosForm
            medicamentosAgregados={data.medicamentos_agregados}
            onChange={(nuevosMedicamentos) => setData('medicamentos_agregados', nuevosMedicamentos)}
            medicamentos={medicamentos}
          />
          {errors.manejo_medicamentos && (
            <div className="text-red-500 text-sm">{errors.manejo_medicamentos}</div>
          )}
        </div>
        <div>
          <TratamientoLaboratoriosForm
            value={data.manejo_laboratorios}
            onChange={(value) => setData('manejo_laboratorios', value)}
            estudios={estudios}
          />
          {errors.manejo_laboratorios && (
            <div className="text-red-500 text-sm">{errors.manejo_laboratorios}</div>
          )}
        </div>
        <div className="mb-4">
          <TratamientoMedidasGeneralesForm
            value={data.manejo_medidas_generales}
            onChange={(value) => setData('manejo_medidas_generales', value)}
          />
          {errors.manejo_medidas_generales && (
            <div className="text-red-500 text-sm">{errors.manejo_medidas_generales}</div>
          )}
        </div>
      </FormLayout>
    )
}
    