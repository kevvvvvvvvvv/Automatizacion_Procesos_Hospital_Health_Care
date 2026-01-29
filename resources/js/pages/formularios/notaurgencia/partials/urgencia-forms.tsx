import React from 'react';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Estancia, Paciente, notaUrgencia } from '@/types';

import PacienteCard from '@/components/paciente-card';
import FormLayout from '@/components/form-layout';
import MainLayout from '@/layouts/MainLayout';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  urgencias: notaUrgencia;
  onSubmit: (form: any )=> void;
  submitLabel?: string;
};
export const Urgenciaform = ({
    onSubmit,
    urgencias,
    submitLabel = "guardado"
}: Props ) => {
    const form = useForm ({
        motivo_atencion: urgencias?.motivo_atencion || '',  
               resumen_interrogatorio: urgencias?.resumen_interrogatorio || '',
               ta: urgencias?.ta || '',
               fc: urgencias?.fc || '',
               fr: urgencias?.fr || '',
               temp: urgencias?.temp || '',
               peso: urgencias?.peso || '',
               talla: urgencias?.talla || '',
               estado_mental: urgencias?.estado_mental || '',
               exploracion_fisica: urgencias?.exploracion_fisica || '',
               resultados_relevantes: urgencias?.resultados_relevantes || '',
               diagnostico_problemas_clinicos: urgencias?.diagnostico_problemas_clinicos || '',  
               tratamiento: urgencias?.tratamiento || '',
               pronostico: urgencias?.pronostico || '',
    });
    const {data, setData, processing, errors } = form;
        const handleSubmit = (e: React.FormEvent) => {
            e.preventDefault();
            onSubmit(form);
        }
        const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;
        const labelClasses = `block text-sm font-medium text-gray-700 mb-1`;
    return (
        <>
            <FormLayout
        title="Registro de Nota de Urgencia Inicial"
        onSubmit={handleSubmit}
        actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Guardando...' : 'Guardar'}</PrimaryButton>}
      >

        
          {/* Sección 1: Signos Vitales */}
                <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Signos vitales</h2>
                <InputText
                  id="ta"
                  label="Tensión arterial"
                  name="ta"
                  value={data.ta}
                  onChange={(e) => setData('ta', e.target.value)}
                  placeholder="Ej: 120/80"
                  error={errors.ta}
                />
                <InputText
                  id="fc"
                  label="Frecuencia cardíaca"
                  name="fc"
                  type="number"
                  value={data.fc?.toString() || ''}
                  onChange={(e) => setData('fc', e.target.value)}
                  placeholder="Ej: 70"
                 
                  error={errors.fc}
                />
                <InputText
                  id="fr"
                  label="Frecuencia respiratoria"
                  name="fr"
                  type="number"
                  value={data.fr?.toString() || ''}
                  onChange={(e) => setData('fr', e.target.value)}
                  placeholder="Ej: 16"
                  
                  error={errors.fr}
                />
                <InputText
                  id="temp"
                  label="Temperatura"
                  name="temp"
                  type="number"
                  value={data.temp?.toString() || ''}
                  onChange={(e) => setData('temp', e.target.value)}
                  placeholder="Ej: 36.50"
                  error={errors.temp}
                />
                <InputText
                  id="peso"
                  label="Peso (kg)"
                  name="peso"
                  type="number"
                  value={data.peso?.toString() || ''}
                  onChange={(e) => setData('peso', e.target.value)}
                  placeholder="Ej: 70.50"
                  error={errors.peso}
                />
                <InputText
                  id="talla"
                  label="Talla (cm)"
                  name="talla"
                  type="number"
                  value={data.talla?.toString() || ''}
                  onChange={(e) => setData('talla', e.target.value)}
                  placeholder="Ej: 175"
                  error={errors.talla}
                />

                <InputTextArea
                    label="Motivo de la atención"
                    id="motivo_consulta"
                    name="motivo_atencion"
                    value={data.motivo_atencion}
                    onChange={(e) => setData('motivo_atencion', e.target.value)}
                    placeholder="Ingrese el motivo de consulta"
                    rows={4}
                    error={errors.motivo_atencion}
                />

                <InputTextArea
                    label="Estado mental"
                    id="estado_mental"
                    name="estado_mental"
                    value={data.estado_mental}
                    onChange={(e) => setData('estado_mental', e.target.value)}
                    placeholder="Ingrese el estado mental"
                    rows={4}
                    error={errors.estado_mental}
                />

                <InputTextArea
                    label="Resumen del interrogatorio"
                    id="resumen_interrogatorio"
                    name="resumen_interrogatorio"
                    value={data.resumen_interrogatorio}
                    onChange={(e) => setData('resumen_interrogatorio', e.target.value)}
                    placeholder="Ingrese el resumen clínico"
                    rows={4}
                    error={errors.resumen_interrogatorio}
                />

                <InputTextArea
                    label="Exploración física"
                    id="exploracion_fisica"
                    name="exploracion_fisica"
                    value={data.exploracion_fisica}
                    onChange={(e) => setData('exploracion_fisica', e.target.value)}
                    placeholder="Ingrese la exploración física"
                    rows={4}
                    error={errors.exploracion_fisica}
                />

                <InputTextArea
                    label="Resultado de estudios de los servicios auxiliares de diagnóstico"
                    id="resultados_relevantes"
                    name="resultados_relevantes"
                    value={data.resultados_relevantes}
                    onChange={(e) => setData('resultados_relevantes', e.target.value)}
                    placeholder="Resultado de estudios de los servicios auxiliares de diagnóstico"
                    rows={4}
                    error={errors.resultados_relevantes}
                />

                <InputTextArea
                    label="Diagnóstico o problemas clínicos"
                    id="diagnostico_problemas_clinicos"
                    name="diagnostico_problemas_clinicos"
                    value={data.diagnostico_problemas_clinicos}
                    onChange={(e) => setData('diagnostico_problemas_clinicos', e.target.value)}
                    placeholder="Ingrese el diagnóstico y problemas clínicos"
                    rows={4}
                    error={errors.diagnostico_problemas_clinicos}
                />

                <InputTextArea
                    label="Tratamiento"
                    id="tratamiento"
                    name="tratamiento"
                    value={data.tratamiento}
                    onChange={(e) => setData('tratamiento', e.target.value)}
                    placeholder="Ingrese el tratamiento"
                    rows={4}
                    error={errors.tratamiento}
                />

                <InputTextArea
                    label="Pronóstico"
                    id="pronostico"
                    name="pronostico"
                    value={data.pronostico}
                    onChange={(e) => setData('pronostico', e.target.value)}
                    placeholder="Ingrese el pronóstico"
                    rows={4}
                    error={errors.pronostico}
                />  
      </FormLayout>
        </>
    );

};


