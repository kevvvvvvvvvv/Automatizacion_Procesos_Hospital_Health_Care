import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { Preoperatoria, Paciente, Estancia, User } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface ShowPreoperatorioProps {
  preoperatoria: Preoperatoria & {
    formularioInstancia?: {
      user?: User;
      estancia: Estancia & { paciente: Paciente };
    };
  };
  paciente: Paciente;
  estancia: Estancia;
}

const Show = ({ preoperatoria, paciente, estancia }: ShowPreoperatorioProps) => {
  const { formularioInstancia } = preoperatoria;

  const dateOptions: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };

  const fechaCirugiaFormatted = preoperatoria.fecha_cirugia
    ? new Date(preoperatoria.fecha_cirugia).toLocaleDateString('es-MX', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      })
    : 'N/A';

 

  return (
    <MainLayout>
      <Head title={`Preoperatorio ${preoperatoria.id}`} />

      <InfoCard
        title={`Valoración Preoperatoria de: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      >
        {/* Datos generales */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
         
          <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full">
            Datos Preoperatorios
          </h2>
          <InfoField
            label="Fecha de Cirugía"
            value={fechaCirugiaFormatted}
          />
        </div>

        {/* Diagnóstico y plan */}
        <h2 className="text-lg font-semibold text-gray-800 mb-2">
          Diagnóstico y Plan Quirúrgico
        </h2>
        <div className="space-y-2 mb-6">
          <InfoField
            label="Diagnóstico Preoperatorio"
            value={preoperatoria.diagnostico_preoperatorio || 'N/A'}
          />
          <InfoField
            label="Tipo de Intervención Quirúrgica"
            value={preoperatoria.tipo_intervencion_quirurgica || 'N/A'}
          />

          <InfoField label="Riesgo Quirúrgico " value={preoperatoria.riesgo_quirurgico || 'N/A'} />        
          <InfoField
            label="Plan Quirúrgico"
            value={preoperatoria.plan_quirurgico || 'N/A'}
          />
         
          <InfoField
            label="Cuidados y Plan Preoperatorios"
            value={preoperatoria.cuidados_plan_preoperatorios || 'N/A'}
          />
          <InfoField
            label="Pronostico"
            value={preoperatoria.pronostico || 'N/A'}
          />
        </div>
      </InfoCard>
    </MainLayout>
  );
};

export default Show;
