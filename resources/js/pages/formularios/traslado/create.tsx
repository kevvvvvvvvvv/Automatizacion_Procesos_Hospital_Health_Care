import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import React from 'react';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente } from '@/types';
import PacienteCard from '@/components/paciente-card';
import Generalidades from '@/components/forms/generalidades';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
};

const CreateTranslado: React.FC<Props> = ({ paciente, estancia }) => {
  const { data, setData, post, processing, errors } = useForm({
    unidad_medica_envia: '',
    motivo_translado: '',
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
    unidad_medica_recibe: '',
    impresion_diagnostica: '',
    terapeutica_empleada: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('pacientes.estancias.traslados.store', {
      paciente: paciente.id,
      estancia: estancia.id,
    }));
  };

  const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;
  const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;

  return (
    <MainLayout
    pageTitle={`Creación de nota de traslado`}
      link="estancias.show"
      
      linkParams={estancia.id} >
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
        <Generalidades data={data} setData={setData} errors={errors} />
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
        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Resumen Clínico</h2>
        <div className="col-span-full md:col-span-1">
          <label htmlFor="motivo_traslado" className={labelClasses}>
            Motivo del Traslado:
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
        <div className="col-span-full md:col-span-2">
          <label htmlFor="impresion_diagnostica" className={labelClasses}>
            Impresión Diagnóstica (incluido abuso y dependencia del tabaco, del alcohol y de otras sustancias
            psicoactivas):
          </label>
          <textarea
            id="impresion_diagnostica"
            name="impresion_diagnostica"
            value={data.impresion_diagnostica}
            onChange={(e) => setData('impresion_diagnostica', e.target.value)}
            placeholder="Describa la impresión diagnóstica"
            rows={4}
            className={`${textAreaClasses} ${errors.impresion_diagnostica ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.impresion_diagnostica && (
            <p className="mt-1 text-xs text-red-500">{errors.impresion_diagnostica}</p>
          )}
        </div>

        {/* Sección 4: Tratamiento */}
       
        <div className="col-span-full">
          <label htmlFor="terapeutica_empleada" className={labelClasses}>
            Tratamiento Terapéutico Administrado:
          </label>
          <textarea
            id="terapeutica_empleada"
            name="terapeutica_empleada"
            value={data.terapeutica_empleada}
            onChange={(e) => setData('terapeutica_empleada', e.target.value)}
            placeholder="Describa el tratamiento administrado..."
            rows={4}
            className={`${textAreaClasses} ${errors.terapeutica_empleada ? 'border-red-500' : 'border-gray-600'}`}
            autoComplete="off"
          />
          {errors.terapeutica_empleada && (
            <p className="mt-1 text-xs text-red-500">{errors.terapeutica_empleada}</p>
          )}
        </div>
      </FormLayout>
    </MainLayout>
  );
};



export default CreateTranslado;
