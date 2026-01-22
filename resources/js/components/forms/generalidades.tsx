import React from 'react';

import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';

interface GeneralidadesProps {
  data: any; 
  setData: (field: string, value: any) => void;
  errors: Record<string, string | undefined>;
}

const Generalidades: React.FC<GeneralidadesProps> = ({ data, setData, errors }) => {

  const getValue = (val: any) => (val !== null && val !== undefined) ? val : '';

  return (
    <>
      <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">
        Signos vitales
      </h2>

      <InputText
        id="ta"
        label="Tensión arterial"
        name="ta"
        value={data.ta ?? ''}
        onChange={(e) => setData('ta', e.target.value)}
        placeholder="Ej: 120/80"
        error={errors.ta}
      />

      <InputText
        id="fc"
        label="Frecuencia cardíaca"
        name="fc"
        type="number"
        value={getValue(data.fc)}
        onChange={(e) => setData('fc', e.target.value)}
        placeholder="Ej: 70"
        error={errors.fc}
      />

      <InputText
        id="fr"
        label="Frecuencia respiratoria"
        name="fr"
        type="number"
        value={getValue(data.fr)}
        onChange={(e) => setData('fr', e.target.value)}
        placeholder="Ej: 16"
        error={errors.fr}
      />

      <InputText
        id="temp"
        label="Temperatura (°C)"
        name="temp"
        type="number"
        value={getValue(data.temp)}
        onChange={(e) => setData('temp', e.target.value)}
        placeholder="Ej: 36.5"
        error={errors.temp}
      />

      <InputText
        id="peso"
        label="Peso (kg)"
        name="peso"
        type="number"
        value={getValue(data.peso)}
        onChange={(e) => setData('peso', e.target.value)}
        placeholder="Ej: 70.5"
        error={errors.peso}
      />

      <InputText
        id="talla"
        label="Talla (cm)"
        name="talla"
        type="number"
        value={getValue(data.talla)}
        onChange={(e) => setData('talla', e.target.value)}
        placeholder="Ej: 175"
        error={errors.talla}
      />

      <InputTextArea
          label="Resumen del interrogatorio"
          id="resumen_del_interrogatorio"
          name="resumen_del_interrogatorio"
          value={data.resumen_del_interrogatorio}
          onChange={(e) => setData('resumen_del_interrogatorio', e.target.value)}
          placeholder="Resumen de la historia clínica..."
          rows={3}
          error={errors.resumen_del_interrogatorio}
      />

      <InputTextArea
          label="Exploración física"
          id="exploracion_fisica"
          name="exploracion_fisica"
          value={data.exploracion_fisica}
          onChange={(e) => setData('exploracion_fisica', e.target.value)}
          placeholder="Hallazgos de la exploración..."
          rows={4}
          error={errors.exploracion_fisica}
      />

      <InputTextArea
          label="Resultado de estudios de los servicios auxiliares de diagnóstico"
          id="resultado_estudios"
          name="resultado_estudios"
          value={data.resultado_estudios}
          placeholder="Describa los resultados..."
          onChange={(e) => setData('resultado_estudios', e.target.value)}
          rows={3}
          error={errors.resultado_estudios}
      />

      <InputTextArea
          label="Tratamiento"
          id="tratamiento"
          name="tratamiento"
          value={data.tratamiento}
          placeholder="Describa el tratamiento..."
          onChange={(e) => setData('tratamiento', e.target.value)}
          rows={3}
          error={errors.tratamiento}
      />

      <InputTextArea
          label="Diagnóstico o problemas clínicos"
          id="diagnostico_o_problemas_clinicos"
          name="diagnostico_o_problemas_clinicos"
          value={data.diagnostico_o_problemas_clinicos}
          onChange={(e) => setData('diagnostico_o_problemas_clinicos', e.target.value)}
          placeholder="Diagnósticos principales..."
          rows={3}
          error={errors.diagnostico_o_problemas_clinicos}
      />

      <InputTextArea
          label="Plan de estudio"
          id="plan_de_estudio"
          name="plan_de_estudio"
          value={data.plan_de_estudio}
          onChange={(e) => setData('plan_de_estudio', e.target.value)}
          placeholder="Plan de estudios adicionales..."
          rows={3}
          error={errors.plan_de_estudio}
      />

      <InputTextArea
          label="Pronóstico"
          id="pronostico"
          name="pronostico"
          value={data.pronostico}
          onChange={(e) => setData('pronostico', e.target.value)}
          placeholder="Describa el pronóstico al egreso"
          rows={4}
          error={errors.pronostico}
      />
    </>
  );
};

export default Generalidades;
