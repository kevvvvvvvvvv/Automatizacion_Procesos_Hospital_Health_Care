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
    <>
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
        {/*Signos vitales */}
        <h2 className="text-lg font-semibold text-gray-800 mb-2">
          Signos vitales 
        </h2>
       <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <InfoField
          label = "Tensión arterial"
          value = {preoperatoria.ta}/>
          <InfoField
          label = "Frecuencia cardiaca"
          value = {preoperatoria.fc}/>
          <InfoField
          label = "Frecuencia respiratoria"
          value = {preoperatoria.fr}/>
          <InfoField 
          label = "Temperatura"
          value = {preoperatoria.temp}/>
          <InfoField
          label = "Peso"
          value = {preoperatoria.peso}/>
          <InfoField
          label = "Talla"
          value = {preoperatoria.talla}/>
        </div>
         <div className="space-y-2 mb-6">
          <InfoField
          label = "Resumen del interrogatorio"
          value = {preoperatoria.resumen_del_interrogatorio ?? 'N/A'}/>
          <InfoField
          label = "Exploración fisica"
          value = {preoperatoria.exploracion_fisica ?? 'N/A'} />
          <InfoField
          label = "Resultado de estudios de los servicios auxiliares de diagnóstico"
          value = {preoperatoria.resultado_estudios ?? 'N/A'}/>
          <InfoField 
          label = "Tratamiento"
          value = {preoperatoria.tratamiento ?? 'N/A'}/>
          <InfoField
          label = "Diagnostico o problemas clinicos"
          value = {preoperatoria.diagnostico_o_problemas_clinicos ?? 'N/A'}/>
          <InfoField 
          label = "Plan de estudios"
          value = {preoperatoria.plan_de_estudio ?? 'N/A'}/>
          <InfoField
          label = "Pronóstico"
          value = {preoperatoria.pronostico ?? 'N/A'} />

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
    </>
  );
};
Show.layout = (page: React.ReactElement) => {
  const { estancia, paciente } = page.props as ShowPreoperatorioProps;

  return (
    <MainLayout
      pageTitle={`Detalles de nota pre-operatoria de ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      {page}
    </MainLayout>
  );
};
export default Show;
