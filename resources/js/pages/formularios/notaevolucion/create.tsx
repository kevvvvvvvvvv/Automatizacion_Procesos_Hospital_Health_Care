import React from 'react';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { CatalogoEstudio, Estancia, Paciente, ProductoServicio, notasEvoluciones } from '@/types';  

import InputText from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';
import FormLayout from '@/components/form-layout';
import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';

import TratamientoDietasForm from '@/components/forms/tratamiento-dietas-form';
import TratamientoSolucionesForm from '@/components/forms/tratamiento-soluciones-form';
import TratamientoMedicamentosForm from '@/components/forms/tratamiento-medicamentos-form';
import TratamientoLaboratoriosForm from '@/components/forms/tratamiento-laboratorios-form';
import TratamientoMedidasGeneralesForm from '@/components/forms/tratamiento-medidas-generales-form';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  nota? :notasEvoluciones;
  soluciones: ProductoServicio[]; 
  medicamentos: ProductoServicio[]; 
  estudios: CatalogoEstudio []; 
};

const CreateNotaEvolucion: React.FC<Props> = ({ paciente, estancia, soluciones, medicamentos, estudios }) => {
  
  const { data, setData, post, processing, errors } = useForm({
    evolucion_actualizacion: '',
    ta: '',
    fc: '',
    fr: '',
    temp: '',
    peso: '',
    talla: '',
    resultados_relevantes: '',
    diagnostico_problema_clinico: '',
    pronostico: '',
    
    manejo_dieta:  '',
    manejo_soluciones:  '',
    manejo_medicamentos:  '',
    manejo_medidas_generales:  '',
    manejo_laboratorios:  '',});

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('pacientes.estancias.notasevoluciones.store', {  
      paciente: paciente.id,
      estancia: estancia.id,
    }));
  };

  const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;
  const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;

  return (
    <MainLayout>
      <PacienteCard
        paciente={paciente}
        estancia={estancia}
      />
      <Head title="Crear Nota de Evolución" />

      <FormLayout
        title="Registro de Nota de Evolución"
        onSubmit={handleSubmit}
        actions={
          <PrimaryButton type="submit" disabled={processing}>
            {processing ? 'Creando...' : 'Crear Nota de Evolución'}
          </PrimaryButton>
        }
      >
        {/* Sección 1: Evolución y Actualización */}
        <div className="mb-4">
          <label htmlFor="evolucion_actualizacion" className={labelClasses}>
            Evolución y Actualización
          </label>
          <textarea
            id="evolucion_actualizacion"
            className={textAreaClasses}
            value={data.evolucion_actualizacion}
            onChange={(e) => setData('evolucion_actualizacion', e.target.value)}
            placeholder="Ingrese la evolución y actualización"
            rows={4}
            autoComplete="off"
          />
          {errors.evolucion_actualizacion && (
            <div className="text-red-500 text-sm">{errors.evolucion_actualizacion}</div>
          )}
        </div>

        {/* Sección 2: Signos Vitales */}
        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">
          Signos Vitales
        </h2>
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
          placeholder="Ej: 70"
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
          error={errors.fr}
        />
        <InputText
          id="temp"
          label="TEMP (Temperatura)"
          name="temp"
          type="number"
          value={data.temp}
          onChange={(e) => setData('temp', e.target.value)}
          placeholder="Ej: 36.50"
          error={errors.temp}
        />
        <InputText
          id="peso"
          label="Peso (kg)"
          name="peso"
          type="number"
          value={data.peso}
          onChange={(e) => setData('peso', e.target.value)}
          placeholder="Ej: 70.50"
          error={errors.peso}
        />
        <InputText
          id="talla"
          label="Talla (m)"
          name="talla"
          type="number"
          value={data.talla}
          onChange={(e) => setData('talla', e.target.value)}
          placeholder="Ej: 1.75"
          error={errors.talla}
        />

        {/* Sección 3: Otros Campos */}
        <div className="mb-4">
          <label htmlFor="resultados_relevantes" className={labelClasses}>
            Resultados Relevantes
          </label>
          <textarea
            id="resultados_relevantes"
            className={textAreaClasses}
            value={data.resultados_relevantes}
            onChange={(e) => setData('resultados_relevantes', e.target.value)}
            placeholder="Ingrese los resultados relevantes de estudios de diagnóstico"
            rows={4}
            autoComplete="off"
          />
          {errors.resultados_relevantes && (
            <div className="text-red-500 text-sm">{errors.resultados_relevantes}</div>
          )}
        </div>

        <div className="mb-4">
          <label htmlFor="diagnostico_problema_clinico" className={labelClasses}>
            Diagnóstico y Problema Clínico
          </label>
          <textarea
            id="diagnostico_problema_clinico"
            className={textAreaClasses}
            value={data.diagnostico_problema_clinico}
            onChange={(e) => setData('diagnostico_problema_clinico', e.target.value)}
            placeholder="Ingrese el diagnóstico y problema clínico"
            rows={4}
            autoComplete="off"
          />
          {errors.diagnostico_problema_clinico && (
            <div className="text-red-500 text-sm">{errors.diagnostico_problema_clinico}</div>
          )}
        </div>

        <div className="mb-4">
          <label htmlFor="pronostico" className={labelClasses}>
            Pronóstico
          </label>
          <textarea
            id="pronostico"
            className={textAreaClasses}
            value={data.pronostico}
            onChange={(e) => setData('pronostico', e.target.value)}
            placeholder="Ingrese el pronóstico"
            rows={4}
            autoComplete="off"
          />
          {errors.pronostico && (
            <div className="text-red-500 text-sm">{errors.pronostico}</div>
          )}
        </div>

        {/* Sección 4: Tratamiento e Indicaciones Médicas */}
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
            value={data.manejo_medicamentos}
            onChange={(value) => setData('manejo_medicamentos', value)}
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
    </MainLayout>
  );
};

export default CreateNotaEvolucion;
