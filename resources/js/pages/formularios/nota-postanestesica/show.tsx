import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { NotaPostanestesica, Paciente, Estancia } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface ShowNotaPostanestesicaProps {
  nota?: NotaPostanestesica;
  paciente?: Paciente;
  estancia?: Estancia;
}

const ShowNotaPostanestesica = (props: ShowNotaPostanestesicaProps) => {

  const { nota, paciente, estancia } = props;

  // Validación de carga de datos
  if (!nota || !paciente || !estancia) {
    return (
      <MainLayout>
        <Head title="Nota Postanestésica" />
        <div className="p-4 bg-red-50 rounded-md">
            <p className="text-red-600 font-medium">
                No se pudieron cargar los datos de la nota postanestésica.
            </p>
        </div>
      </MainLayout>
    );
  }

  return (
    <MainLayout
      pageTitle="Nota Postanestésica"
      link="estancias.show"
      linkParams={estancia.id}
    >
      <Head title={`Nota Postanestésica ${nota.id}`} />

      <InfoCard
        title={`Nota Postanestésica de: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      >
        {/* SECCIÓN 1: SIGNOS VITALES Y EXPLORACIÓN */}
        <h2 className="text-lg font-semibold text-gray-800 mb-4 col-span-full border-b pb-1">
          Signos Vitales y Exploración Física
        </h2>
        <div className="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
          <InfoField label="Tensión Arterial" value={nota.ta ?? 'N/A'} />
          <InfoField label="Frecuencia Cardíaca" value={nota.fc ? `${nota.fc} lpm` : 'N/A'} />
          <InfoField label="Frecuencia Resp." value={nota.fr ? `${nota.fr} rpm` : 'N/A'} />
          <InfoField label="Temperatura" value={nota.temp ? `${nota.temp} °C` : 'N/A'} />
          <InfoField label="Peso" value={nota.peso ? `${nota.peso} kg` : 'N/A'} />
          <InfoField label="Talla" value={nota.talla ? `${nota.talla} cm` : 'N/A'} />
          
          <div className="col-span-full space-y-4 mt-2">
            <InfoField label="Resumen del Interrogatorio" value={nota.resumen_del_interrogatorio ?? 'N/A'} />
            <InfoField label="Exploración Física" value={nota.exploracion_fisica ?? 'N/A'} />
          </div>
        </div>

        {/* SECCIÓN 2: DETALLES DE LA ANESTESIA */}
        <h2 className="text-lg font-semibold text-gray-800 mb-4 col-span-full border-b pb-1">
          Detalles de la Técnica Anestésica
        </h2>
        <div className="space-y-4 mb-6">
          <InfoField label="Técnica Anestésica Utilizada" value={nota.tecnica_anestesica ?? 'N/A'} />
          <InfoField label="Fármacos Administrados" value={nota.farmacos_administrados ?? 'N/A'} />
          <InfoField label="Duración de la Anestesia" value={nota.duracion_anestesia ?? 'N/A'} />
          <InfoField label="Incidentes o Contingencias" value={nota.incidentes_anestesia ?? 'N/A'} />
        </div>

        {/* SECCIÓN 3: ESTADO CLÍNICO Y PLAN */}
        <h2 className="text-lg font-semibold text-gray-800 mb-4 col-span-full border-b pb-1">
          Estado Clínico y Plan de Manejo
        </h2>
        <div className="space-y-4 mb-6">
          <InfoField label="Balance Hídrico" value={nota.balance_hidrico ?? 'N/A'} />
          <InfoField label="Estado Clínico al Egreso de Quirófano" value={nota.estado_clinico ?? 'N/A'} />
          <InfoField label="Plan de Manejo y Tratamiento Inmediato" value={nota.plan_manejo ?? 'N/A'} />
          
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <InfoField label="Diagnóstico o Problemas Clínicos" value={nota.diagnostico_o_problemas_clinicos ?? 'N/A'} />
            <InfoField label="Pronóstico" value={nota.pronostico ?? 'N/A'} />
          </div>
        </div>
      </InfoCard>
    </MainLayout>
  );
};

export default ShowNotaPostanestesica;