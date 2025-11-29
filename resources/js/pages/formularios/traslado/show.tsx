import React from 'react';
import { Head, Link } from '@inertiajs/react';

import MainLayout from '@/layouts/MainLayout';
import { Traslado, Paciente, Estancia, User } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface ShowTrasladoProps {
  traslado: Traslado & {
    formularioInstancia?:{
      user?: User;
      estancia: Estancia & { paciente: Paciente };
    };
  };
  paciente: Paciente;
  estancia: Estancia;
}
const Show = ({ traslado, paciente, estancia }: ShowTrasladoProps) => {
    const { formularioInstancia } = traslado;   
    const dateOptions: Intl.DateTimeFormatOptions = {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit',
    };  

    return (
        <>
            <Head title={`Traslado ${traslado.id}`} />
            <InfoCard title={`Detalles del Traslado para: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}>
                 <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full">
          Signos Vitales
        </h2>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                  <InfoField
                    label="T.A. (Tensión Arterial)"
                    value={traslado.ta ?? 'N/A'}
                  />
                  <InfoField
                    label="FC (Frecuencia Cardíaca)"
                    value={traslado.fc ?? 'N/A'}
                  />
                  <InfoField
                    label="FR (Frecuencia Respiratoria)"
                    value={traslado.fr ?? 'N/A'}
                  />
                  <InfoField
                    label="TEMP (Temperatura)"
                    value={traslado.temp ?? 'N/A'}
                  />
                  <InfoField
                    label="Peso (kg)"
                    value={traslado.peso ?? 'N/A'}
                  />
                  <InfoField
                    label="Talla (m)"
                    value={traslado.talla ?? 'N/A'}
                  />
                </div>
                <div className="grid grid-cols-1  gap-4 mb-6">
                    <InfoField
                    label="Resumen del interrogatorio" value={traslado.resumen_del_interrogatorio}/>
                    <InfoField label="Exploración fisica" value={traslado.exploracion_fisica}/>
                    <InfoField label="Diagnostivo o problemas clinicos" value={traslado.diagnostico_o_problemas_clinicos}/>
                    <InfoField label="Resultado de estudios de los servicios auxiliares de diagnóstico y tratamiento" value={traslado.resultado_estudios}/>
                    <InfoField label="Plan de estudios" value={traslado.plan_de_estudio}/>
                    <InfoField label="Pronostico" value={traslado.pronostico}/>
                    <InfoField label="Tratamiento" value={traslado.tratamiento}/>
                </div>
                <div className="grid grid-cols-1  gap-4 mb-6">
                    <h1 className="text-2xl font-bold mb-4">{`Organizaciones de traslado `}</h1>
                    <InfoField label ="Unidad Médica que Envía" value={traslado.unidad_medica_envia || 'N/A'} />
                    <InfoField label ="Unidad Médica que Recibe" value={traslado.unidad_medica_recibe || 'N/A'} />
                    <InfoField label ="Motivo del Traslado" value={traslado.motivo_translado || 'N/A'} />
                    <InfoField label ="Impresión Diagnóstica" value={traslado.impresion_diagnostica || 'N/A'} />
                    <InfoField label ="Terapéutica empleada" value={traslado.terapeutica_empleada || 'N/A'} />
                </div>
            </InfoCard>
        </>
    );
};
Show.layout = (page: React.ReactElement) => {
  const {estancia, paciente} = page.props as ShowTrasladoProps;
  return(
    <MainLayout
    pageTitle={`Nota de traslado de ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
    link="estancias.show"
    linkParams={{estancia: estancia.id}}
    >
    {page} </MainLayout>
  )
}

export default Show;