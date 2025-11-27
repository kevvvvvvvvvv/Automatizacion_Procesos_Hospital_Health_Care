import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { notaUrgencia, Paciente, Estancia, User } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface ShowNotaUrgenciaProps {
  notaUrgencia: notaUrgencia & {
    formularioInstancia?: {
      user?: User;
      estancia: Estancia & { paciente: Paciente };
    };
  };
  paciente: Paciente;
  estancia: Estancia;
}

const Show = ({ notaUrgencia, paciente, estancia }: ShowNotaUrgenciaProps) => {
  const dateOptions: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };

  return (
    <>
      <Head title={`Nota de Urgencia ${notaUrgencia.id}`} />

      <InfoCard
        title={`Nota de Urgencia Inicial de: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      >
        <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full">
          Signos Vitales
        </h2>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <InfoField
            label="T.A. (Tensión Arterial)"
            value={notaUrgencia.ta ?? 'N/A'}
          />
          <InfoField
            label="FC (Frecuencia Cardíaca)"
            value={notaUrgencia.fc ?? 'N/A'}
          />
          <InfoField
            label="FR (Frecuencia Respiratoria)"
            value={notaUrgencia.fr ?? 'N/A'}
          />
          <InfoField
            label="TEMP (Temperatura)"
            value={notaUrgencia.temp ?? 'N/A'}
          />
          <InfoField
            label="Peso (kg)"
            value={notaUrgencia.peso ?? 'N/A'}
          />
          <InfoField
            label="Talla (m)"
            value={notaUrgencia.talla ?? 'N/A'}
          />
        </div>

        <h2 className="text-lg font-semibold text-gray-800 mb-2">
          Detalles de la Consulta
        </h2>
        <div className="space-y-2 mb-6">
          <InfoField
            label="Motivo de Atención"
            value={notaUrgencia.motivo_atencion ?? 'N/A'}
          />
          <InfoField
            label="Estado Mental"
            value={notaUrgencia.estado_mental ?? 'N/A'}
          />
          <InfoField
            label="Resumen del Interrogatorio"
            value={notaUrgencia.resumen_interrogatorio ?? 'N/A'}
          />
          <InfoField
            label="Exploración Física"
            value={notaUrgencia.exploracion_fisica ?? 'N/A'}
          />
          <InfoField
            label="Resultados Relevantes de Estudios de Diagnóstico"
            value={notaUrgencia.resultados_relevantes ?? 'N/A'}
          />
          <InfoField
            label="Diagnóstico y Problemas Clínicos"
            value={notaUrgencia.diagnostico_problemas_clinicos ?? 'N/A'}
          />
          <InfoField
            label="Tratamiento"
            value={notaUrgencia.tratamiento ?? 'N/A'}
          />
          <InfoField
            label="Pronóstico"
            value={notaUrgencia.pronostico ?? 'N/A'}
          />
        </div>
      </InfoCard>
    </>
  );
};


Show.layout = (page: React.ReactElement) => {
  const { estancia, paciente } = page.props as ShowNotaUrgenciaProps;

  return (
    <MainLayout
      pageTitle={`Nota de Urgencia de ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      link="estancias.show"
      linkParams={{ estancia: estancia.id }} 
    >
      {page}
    </MainLayout>
  );
};

export default Show;
