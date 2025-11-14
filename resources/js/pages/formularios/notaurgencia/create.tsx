import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente, notaUrgencia } from '@/types';
import PacienteCard from '@/components/paciente-card';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
};
const CreateNotaUrgencia: React.FC<Props> = ({ paciente, estancia }) => {
   const { data, setData, post, processing, errors } = useForm({
       motivo_atencion: '',  // Cambiado de motivo_consulta
       resumen_interrogatorio: '',
       ta: '',
       fc: '',
       fr: '',
       temp: '',
       peso: '',
       talla: '',
       estado_mental: '',
       exploracion_fisica: '',
       resultados_relevantes: '',
       diagnostico_problemas_clinicos: '',  
       tratamiento: '',
       pronostico: '',
   });
    const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    //console.log('Datos', data);
    post(route('pacientes.estancias.notasurgencias.store', {
      paciente: paciente.id,
      estancia: estancia.id,
    }));
  };

  const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;
  const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;
    return (
    <><MainLayout>
      <PacienteCard
        paciente={paciente}
        estancia={estancia}
      />
      <Head title="Crear Nota de Urgencia Inicial" />
        
      <FormLayout
        title="Registro de Nota de Urgencia Inicial"
        onSubmit={handleSubmit}
        actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Creando...' : 'Crear Nota de Urgencia'}</PrimaryButton>}
      >

        
          {/* Sección 1: Signos Vitales */}
                <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Signos Vitales</h2>
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
            {/* Sección 1: Motivo de Consulta */}
        <div className="mb-4">
          <label htmlFor="motivo_consulta" className={labelClasses}>Motivo de Consulta</label>
          <textarea
            id="motivo_consulta"
            className={textAreaClasses}
            value={data.motivo_atencion}
            onChange={e => setData('motivo_atencion', e.target.value)}
            placeholder="Ingrese el motivo de consulta"
            rows={4}
            autoComplete="off"
          />
          {errors.motivo_atencion && <div className="text-red-500 text-sm">{errors.motivo_atencion}</div>}
        </div>
        <div className="mb-4">
            <label htmlFor="estado_mental" className={labelClasses}>Estado mental</label>
            <textarea
              id="estado_mental"
              className={textAreaClasses}
              value={data.estado_mental}
              onChange={e => setData('estado_mental', e.target.value)}
              placeholder="Ingrese el estado mental"
              rows={4}
            autoComplete="off"
            />
            {errors.estado_mental && <div className="text-red-500 text-sm">{errors.estado_mental}</div>}
        </div>
        <div className="mb-4">
            <label htmlFor="resumen_interrogatorio" className={labelClasses}>Resumen del interrogatorio</label>
            <textarea
              id="resumen_interrogatorio"
              className={textAreaClasses}
              value={data.resumen_interrogatorio}
              onChange={e => setData('resumen_interrogatorio', e.target.value)}
              placeholder="Ingrese el resumen clínico"
              rows={4}
            autoComplete="off"
            />
            {errors.resumen_interrogatorio && <div className="text-red-500 text-sm">{errors.resumen_interrogatorio}</div>}
        </div>
        <div className="mb-4">
            <label htmlFor="exploracion_fisica" className={labelClasses}>Exploración física</label>
            <textarea
              id="exploracion_fisica"
              className={textAreaClasses}
              value={data.exploracion_fisica}
              onChange={e => setData('exploracion_fisica', e.target.value)}
              placeholder="Ingrese la exploración física"
              rows={4}
            autoComplete="off"
            />
            {errors.exploracion_fisica && <div className="text-red-500 text-sm">{errors.exploracion_fisica}</div>}
        </div>
        
        <div className="mb-4">
            <label htmlFor="resultados_relevantes" className={labelClasses}>Resultados relevantes de estudios de diagnostico</label>
            <textarea
              id="resultados_relevantes"
              className={textAreaClasses}
              value={data.resultados_relevantes}
              onChange={e => setData('resultados_relevantes', e.target.value)}
              placeholder="Ingrese los resultados relevantes"
              rows={4}
            autoComplete="off"
            />
            {errors.resultados_relevantes && <div className="text-red-500 text-sm">{errors.resultados_relevantes}</div>}
        </div>
        <div className="mb-4">
            <label htmlFor="diagnostico_problemas_clinicos" className={labelClasses}>Diagnóstico y problemas clínicos</label>
            <textarea
                id="diagnostico_problemas_clinicos"
                className={textAreaClasses}
                value={data.diagnostico_problemas_clinicos}
                onChange={e => setData('diagnostico_problemas_clinicos', e.target.value)}
                placeholder="Ingrese el diagnóstico y problemas clínicos"
                rows={4}
            autoComplete="off"
            />
            {errors.diagnostico_problemas_clinicos && <div className="text-red-500 text-sm">{errors.diagnostico_problemas_clinicos}</div>}
        </div>
        <div className="mb-4">
            <label htmlFor="tratamiento" className={labelClasses}>Tratamiento</label>
            <textarea
                id="tratamiento"
                className={textAreaClasses}
                value={data.tratamiento}
                onChange={e => setData('tratamiento', e.target.value)}
                placeholder="Ingrese el tratamiento"
                rows={4}
            autoComplete="off"
            />
        </div>
        <div className="mb-4">
            <label htmlFor="pronostico" className={labelClasses}>Pronóstico</label>
            <textarea
                id="pronostico"
                className={textAreaClasses}
                value={data.pronostico}
                onChange={e => setData('pronostico', e.target.value)}
                placeholder="Ingrese el pronóstico"
                rows={4}
            autoComplete="off"
            />
        </div>
      </FormLayout>
      </MainLayout>
    </>
  );
};

export default CreateNotaUrgencia;