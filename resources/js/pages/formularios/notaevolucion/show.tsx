import React from 'react';
import {Head} from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { notasEvoluciones, Paciente, Estancia, User } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface ShowNotaEvolucionProps{
    notaevolucion: notasEvoluciones & {
        formularioInstancia?: {
            user?: User;
            estancia: Estancia & {paciente:Paciente};
        };
    };
    paciente: Paciente;
    estancia: Estancia;
}

const Show = ({notaevolucion, paciente, estancia}: ShowNotaEvolucionProps) => {
   

    const dateOptions: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };

  return (
    <MainLayout>
        <Head title={`Nota de Evolución ${notaevolucion.id}` }/>

        <InfoCard
        title={`Nota de evolución de: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}>
            <div className='grid grid-cols-1 md:grid-cols-3 gap-4 mb-6'>
                <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full">
            Evolución y actualización
          </h2>
           <InfoField 
            label="Evaluación y actualización"
            value={notaevolucion.evolucion_actualizacion}/>
        </div>
        <h2 className='text-lg font-semibold text-gray-800 mb-2'>
            Signos Vitales
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        
            <InfoField
            label= "Tensión Arterial"
            value= {notaevolucion.ta || 'N/A'}/>
            <InfoField
            label= "Frecuencia cardiaca"
            value= {notaevolucion.fc || 'N/A'}/>
            <InfoField
            label= "Frecuencia respiratoria"
            value= {notaevolucion.fr || 'N/A'}/>
            <InfoField
            label= "Temperatura"
            value= {notaevolucion.temp || 'N/A'}/>
            <InfoField
            label= "Peso"
            value= {notaevolucion.peso || 'N/A'}/>
           
        </div>
        
        <div className="space-y-2 mb-6">
            <h2 className='text-lg font-semibold text-gray-800 mb-2'>
            Resultados
        </h2>
             <InfoField
            label= "Resultados Relevantes"
            value = {notaevolucion.resultados_relevantes || 'N/A'}/>
            <InfoField
            label= "diagnostico y problemas clinicos"
            value = {notaevolucion.diagnostico_problema_clinico || 'N/A'}/>
            <InfoField
            label= "Pronostico"
            value = {notaevolucion.pronostico || 'N/A'}/>
        </div>
        <div className="space-y-2 mb-6">
            <h2 className='text-lg font-semibold text-gray-800 mb-2'>
           Tratamnmiento e Indicaciones médicas</h2>
            <InfoField
            label="Plan de dieta"
            value = {notaevolucion.manejo_dieta || 'N/A'}/>
            <InfoField
            label="Plan de soliciones"
            value = {notaevolucion.manejo_soluciones || 'N/A'}/>
            <InfoField
            label = "Plan de medicamentos"
            value = {notaevolucion.manejo_medicamentos || 'N/A'}/>
            <InfoField
            label = "Plan de estudios"
            value = {notaevolucion.manejo_laboratorios || 'N/A'}/>
            <InfoField
            label = "Plan de medidas generales"
            value = {notaevolucion.manejo_medidas_generales || 'N/A'}/>  
        </div>
           

        </InfoCard>
    </MainLayout>
  )
}
export default Show;
