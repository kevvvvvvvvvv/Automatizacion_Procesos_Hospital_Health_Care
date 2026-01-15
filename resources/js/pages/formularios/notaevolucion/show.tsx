import React from 'react';
import {Head} from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { notasEvoluciones, Paciente, Estancia, User } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface ShowNotaEvolucionProps{
    notasevolucione: notasEvoluciones & {
        formularioInstancia?: {
            user?: User;
            estancia: Estancia & {paciente:Paciente};
        };
    };
    paciente: Paciente;
    estancia: Estancia;
}

const Show = ({notasevolucione, paciente, estancia}: ShowNotaEvolucionProps) => {
   

    const dateOptions: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };

  return (
    <>
        <Head title={`Nota de Evolución ` }/>

        <InfoCard
        title={`Nota de evolución de: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}>
            <div className='grid grid-cols-1 md:grid-cols-3 gap-4 mb-6'>
                <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full">
            Evolución y actualización
          </h2>
           <InfoField 
            label="Evaluación y actualización"
            value={notasevolucione.evolucion_actualizacion}/>
        </div>
        <h2 className='text-lg font-semibold text-gray-800 mb-2'>
            Signos Vitales
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        
            <InfoField
            label= "Tensión Arterial"
            value= {notasevolucione.ta || 'N/A'}/>
            <InfoField
            label= "Frecuencia cardiaca"
            value= {notasevolucione.fc || 'N/A'}/>
            <InfoField
            label= "Frecuencia respiratoria"
            value= {notasevolucione.fr || 'N/A'}/>
            <InfoField
            label= "Temperatura"
            value= {notasevolucione.temp || 'N/A'}/>
            <InfoField
            label= "Peso"
            value= {notasevolucione.peso || 'N/A'}/>
           <InfoField
            label= "Talla"
            value= {notasevolucione.talla || 'N/A'}/>
        </div>
        
        <div className="space-y-2 mb-6">
            <h2 className='text-lg font-semibold text-gray-800 mb-2'>
            Resultados
        </h2>
             <InfoField
            label= "Resultados Relevantes"
            value = {notasevolucione.resultado_estudios || 'N/A'}/>
            <InfoField
            label= "diagnostico y problemas clinicos"
            value = {notasevolucione.diagnostico_o_problemas_clinicos || 'N/A'}/>
            <InfoField
            label= "Pronostico"
            value = {notasevolucione.pronostico || 'N/A'}/>
        </div>
        <div className="space-y-2 mb-6">
            <h2 className='text-lg font-semibold text-gray-800 mb-2'>
           Tratamnmiento e Indicaciones médicas</h2>
            <InfoField
            label="Plan de dieta"
            value = {notasevolucione.manejo_dieta || 'N/A'}/>
            <InfoField
            label="Plan de soliciones"
            value = {notasevolucione.manejo_soluciones || 'N/A'}/>
            <InfoField
            label = "Plan de medicamentos"
            value = {notasevolucione.manejo_medicamentos || 'N/A'}/>
            <InfoField
            label = "Plan de estudios"
            value = {notasevolucione.manejo_laboratorios || 'N/A'}/>
            <InfoField
            label = "Plan de medidas generales"
            value = {notasevolucione.manejo_medidas_generales || 'N/A'}/>  
        </div>
           

        </InfoCard>
    </>
  )
}
Show.layout = (page: React.ReactElement) => {
  const { estancia, paciente } = page.props as ShowNotaEvolucionProps;

  return (
    <MainLayout
      pageTitle={`Detalles de nota de evolucion de ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      link='estancias.show'
      linkParams={estancia.id}    
    >
      {page}
    </MainLayout>
  );
};
export default Show;
