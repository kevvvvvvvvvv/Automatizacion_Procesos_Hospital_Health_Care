import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente } from '@/types';
import PacienteCard from '@/components/paciente-card';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
};

const CreateTranslado: React.FC<Props> = ({ paciente, estancia }) => {
  const { data, setData, post, processing, errors } = useForm({
    unidad_medica_envia: '',
    motivo_translado: '',
    unidad_medica_recibe: '',
    resumen_clinico: '',
    ta: '',
    fc: '',
    fr: '',
    sat: '',
    temp: '',
    dxtx: '',
    tratamiento_terapeutico_administradao: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('pacientes.estancias.translados.store', {
      paciente: paciente.id,
      estancia: estancia.id,
    }));
  };

  const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;
  const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;

  return (
    <>
      <PacienteCard
        paciente={paciente}
        estancia={estancia}
      />
      <Head title="Crear Traslado" />

      <FormLayout
        title="Registrar Nuevo Traslado"
        onSubmit={handleSubmit}
        actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Creando...' : 'Crear Traslado'}</PrimaryButton>}
      >
        {/* Sección 1: Establecimiento de Salud */}
        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Establecimiento de Salud</h2>
        <InputText
          id="unidad_medica_envia"
          label="Unidad Médica que Envía"
          name="unidad_medica_envia"
          value={data.unidad_medica_envia}
          onChange={(e) => setData('unidad_medica_envia', e.target.value)}
          placeholder="Nombre de la unidad que envía"
          error={errors.unidad_medica_envia}
        />
        <InputText
          id="unidad_medica_recibe"
          label="Unidad Médica que Recibe"
          name="unidad_medica_recibe"
          value={data.unidad_medica_recibe}
          onChange={(e) => setData('unidad_medica_recibe', e.target.value)}
          placeholder="Nombre de la unidad que recibe"
          error={errors.unidad_medica_recibe}
        />

        {/* Sección 2: Motivo y Resumen */}
        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Motivo y Resumen</h2>
        <div className="col-span-full md:col-span-1">
          <label htmlFor="motivo_translado" className={labelClasses}>
            Motivo del Traslado
          </label>
          <textarea
            id="motivo_translado"
            name="motivo_translado"
            value={data.motivo_translado}
            onChange={(e) => setData('motivo_translado', e.target.value)}
            placeholder="Describa el motivo del traslado..."
            rows={3}
            className={`${textAreaClasses} ${errors.motivo_translado ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.motivo_translado && (
            <p className="mt-1 text-xs text-red-500">{errors.motivo_translado}</p>
          )}
        </div>
        <div className="col-span-full md:col-span-1">
          <label htmlFor="resumen_clinico" className={labelClasses}>
            Resumen Clínico
          </label>
          <textarea
            id="resumen_clinico"
            name="resumen_clinico"
            value={data.resumen_clinico}
            onChange={(e) => setData('resumen_clinico', e.target.value)}
            placeholder="Resumen de la condición clínica..."
            rows={3}
            className={`${textAreaClasses} ${errors.resumen_clinico ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.resumen_clinico && (
            <p className="mt-1 text-xs text-red-500">{errors.resumen_clinico}</p>
          )}
        </div>

        {/* Sección 3: Signos Vitales */}
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
          id="sat"
          label="SAT (Saturación de Oxígeno)"
          name="sat"
          type="number"
          value={data.sat}
          onChange={(e) => setData('sat', e.target.value)}
          placeholder="Ej: 98"
          min={0}
          max={100}
          error={errors.sat}
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
          min={20}
          error={errors.temp}
        />
         <InputText
          id="dxtx"
          label="DXTX (Glucometría Capilar)"
          name="dxtx"
          type="text"
          value={data.dxtx}
          onChange={(e) => setData('dxtx', e.target.value)}
          placeholder="Ej: 16"
          min={0}
          error={errors.fr}
        />

        {/* Sección 4: Tratamiento */}
        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Tratamiento</h2>
        <div className="col-span-full">
          <label htmlFor="tratamiento_terapeutico_administradao" className={labelClasses}>
            Tratamiento Terapéutico Administrado
          </label>
          <textarea
            id="tratamiento_terapeutico_administradao"
            name="tratamiento_terapeutico_administradao"
            value={data.tratamiento_terapeutico_administradao}
            onChange={(e) => setData('tratamiento_terapeutico_administradao', e.target.value)}
            placeholder="Describa el tratamiento administrado..."
            rows={4}
            className={`${textAreaClasses} ${errors.tratamiento_terapeutico_administradao ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.tratamiento_terapeutico_administradao && (
            <p className="mt-1 text-xs text-red-500">{errors.tratamiento_terapeutico_administradao}</p>
          )}
        </div>
      </FormLayout>
    </>
  );
};

CreateTranslado.layout = (page: React.ReactElement) => {
  return (
    <MainLayout pageTitle="Creación de Traslado" children={page} />
  );
};

export default CreateTranslado;
