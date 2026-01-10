import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { notasEgresos, Paciente, Estancia, User } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';
import estancias from '@/routes/estancias';

interface ShowNotaEgresoProps {
  notaEgreso?: notasEgresos & {
    formularioInstancia?: {
      user?: User;
      estancia: Estancia & { paciente: Paciente };
    };
  };
  paciente?: Paciente;
  estancia?: Estancia;
}

const ShowNotaEgreso = (props: ShowNotaEgresoProps) => {
  console.log('Props completos desde Inertia:', props);

  const { notaEgreso, paciente, estancia } = props;

   if (!notaEgreso || !paciente || !estancia) {
    return (
      <MainLayout
      >
        <Head title="Nota de egreso" />
        <p className="text-red-600">
          No se pudieron cargar los datos de la nota de egreso.
        </p>
      </MainLayout>
    );
  }

  const { formularioInstancia } = notaEgreso;

  const dateOptions: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };

  return (
    <MainLayout
    pageTitle='Nota de egreso'
      link='estancias.show'
      linkParams={estancia.id}>
      <Head title={`Nota de Egreso ${notaEgreso.id}`} />

      <InfoCard
        title={`Nota de Egreso de: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      >
        <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full">
          Motivo y Diagnósticos
        </h2>

        <div className="grid grid-cols-1 gap-4 mb-6">
          <InfoField
            label="Motivo de Egreso"
            value={notaEgreso.motivo_egreso ?? 'N/A'}
          />
          <InfoField
            label="Diagnósticos Finales"
            value={notaEgreso.diagnosticos_finales ?? 'N/A'}
          />
        </div>

        <h2 className="text-lg font-semibold text-gray-800 mb-2">
          Evolución y Manejo
        </h2>
        <div className="space-y-2 mb-6">
          <InfoField
            label="Resumen de la Evolución y Estado Actual"
            value={notaEgreso.resumen_evolucion_estado_actual ?? 'N/A'}
          />
          <InfoField
            label="Manejo Durante la Estancia"
            value={notaEgreso.manejo_durante_estancia ?? 'N/A'}
          />
          <InfoField
            label="Problemas Pendientes"
            value={notaEgreso.problemas_pendientes ?? 'N/A'}
          />
        </div>

        <h2 className="text-lg font-semibold text-gray-800 mb-2">
          Plan y Recomendaciones
        </h2>
        <div className="space-y-2 mb-6">
          <InfoField
            label="Plan de Manejo y Tratamiento"
            value={notaEgreso.plan_manejo_tratamiento ?? 'N/A'}
          />
          <InfoField
            label="Recomendaciones"
            value={notaEgreso.recomendaciones ?? 'N/A'}
          />
          <InfoField
            label="Factores de Riesgo"
            value={notaEgreso.factores_riesgo ?? 'N/A'}
          />
          <InfoField
            label="Pronóstico"
            value={notaEgreso.pronostico ?? 'N/A'}
          />
          <InfoField
            label="Defunción (en su caso)"
            value={notaEgreso.defuncion ?? 'N/A'}
          />
        </div>
      </InfoCard>
    </MainLayout>
  );
};

export default ShowNotaEgreso;
