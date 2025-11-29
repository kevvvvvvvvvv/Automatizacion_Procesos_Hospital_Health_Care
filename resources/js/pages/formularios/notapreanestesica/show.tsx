

import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { NotaPreAnestesica, Paciente, Estancia, User } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface ShowNotaPreanestesicaProps {
  notaPreanestesica: NotaPreAnestesica & {
    formularioInstancia?: {
      user?: User;
      estancia: Estancia & { paciente: Paciente };
    };
  };
  paciente: Paciente;
  estancia: Estancia;
}

const Show = ({ notaPreanestesica, paciente, estancia }: ShowNotaPreanestesicaProps) => {
  const { formularioInstancia } = notaPreanestesica;

  console.log('notaPreanestesica desde Inertia:', notaPreanestesica);

  const dateOptions: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };

  return (
    <MainLayout>
      <Head title={`Nota Preanestésica ${notaPreanestesica.id}`} />

      <InfoCard
        title={`Nota Preanestésica de: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      >
        {/* Signos vitales */}
        <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full">
          Signos Vitales
        </h2>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <InfoField
            label="T.A. (Tensión Arterial)"
            value={notaPreanestesica.ta ?? 'N/A'}
          />
          <InfoField
            label="FC (Frecuencia Cardíaca)"
            value={notaPreanestesica.fc ?? 'N/A'}
          />
          <InfoField
            label="FR (Frecuencia Respiratoria)"
            value={notaPreanestesica.fr ?? 'N/A'}
          />
          <InfoField
            label="TEMP (Temperatura)"
            value={notaPreanestesica.temp ?? 'N/A'}
          />
          <InfoField
            label="Peso (kg)"
            value={notaPreanestesica.peso ?? 'N/A'}
          />
          <InfoField
            label="Talla (m)"
            value={notaPreanestesica.talla ?? 'N/A'}
          />
        </div>

        {/* Interrogatorio y exploración */}
        <h2 className="text-lg font-semibold text-gray-800 mb-2">
          Interrogatorio y Exploración
        </h2>
        <div className="space-y-2 mb-6">
          <InfoField
            label="Resumen del Interrogatorio"
            value={notaPreanestesica.resumen_del_interrogatorio ?? 'N/A'}
          />
          <InfoField
            label="Exploración Física"
            value={notaPreanestesica.exploracion_fisica ?? 'N/A'}
          />
        </div>

        {/* Diagnóstico y plan de estudio */}
        <h2 className="text-lg font-semibold text-gray-800 mb-2">
          Diagnóstico y Plan de Estudio
        </h2>
        <div className="space-y-2 mb-6">
          <InfoField
            label="Diagnóstico o Problemas Clínicos"
            value={notaPreanestesica.diagnostico_o_problemas_clinicos ?? 'N/A'}
          />
          <InfoField
            label="Plan de Estudio"
            value={notaPreanestesica.plan_de_estudio ?? 'N/A'}
          />
          <InfoField
            label="Pronóstico"
            value={notaPreanestesica.pronostico ?? 'N/A'}
          />
          <InfoField
            label = "Resultados relevantes de servicios auxiliares"
            value = {notaPreanestesica.resultado_estudios ?? 'N/A'}/>
          <InfoField
            label = "Tratamiento"
            value = {notaPreanestesica.tratamiento ?? 'N/A'}/>
        </div>

        {/* Plan terapéutico y anestésico */}
        <h2 className="text-lg font-semibold text-gray-800 mb-2">
          Plan Terapéutico y Anestésico
        </h2>
        <div className="space-y-2 mb-6">
          <InfoField
            label="Plan de Estudios y Tratamiento"
            value={notaPreanestesica.plan_estudios_tratamiento ?? 'N/A'}
          />
          <InfoField
            label="Evaluación Clínica"
            value={notaPreanestesica.evaluacion_clinica ?? 'N/A'}
          />
          <InfoField
            label="Plan Anestésico"
            value={notaPreanestesica.plan_anestesico ?? 'N/A'}
          />
        </div>

        {/* Riesgos e indicaciones */}
        <h2 className="text-lg font-semibold text-gray-800 mb-2">
          Riesgos e Indicaciones
        </h2>
        <div className="space-y-2 mb-2">
          <InfoField
            label="Valoración de Riesgos"
            value={notaPreanestesica.valoracion_riesgos ?? 'N/A'}
          />
          <InfoField
            label="Indicaciones y Recomendaciones"
            value={notaPreanestesica.indicaciones_recomendaciones ?? 'N/A'}
          />
        </div>
      </InfoCard>
    </MainLayout>
  );
};

export default Show;
