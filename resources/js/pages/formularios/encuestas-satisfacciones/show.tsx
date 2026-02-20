import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { EncuestaSatisfaccion, Paciente, Estancia, User } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface showEncuestaSatisfaccionProps {
    encuestaSatisfaccion?: EncuestaSatisfaccion & {
        formularioInstancia?: {
            user?: User;
            estancia:Estancia & {paciente :Paciente}
        };
    };
    paciente?: Paciente;
    estancia?: Estancia;
}
const showEncuestaSatisfaccion = (props: showEncuestaSatisfaccionProps) =>{
    
    const { encuestaSatisfaccion, estancia, paciente} = props;
    
    /*if (!encuestaSatisfaccion || !paciente || !estancia) {
    return (
      <MainLayout
      >
        <Head title="Encuesta de satisfacción" />
        <p className="text-red-600">
          No se pudieron cargar los datos de la encuesta de satisfacción.
        </p>
      </MainLayout>
    );
  }*/

     const dateOptions: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };
  return (
    <MainLayout 
    pageTitle='Encuesta de satisfacción'
     link='estancias.show'
      linkParams={estancia?.id}>
        <Head title='Encuesta de satisfacción'/>
        <InfoCard
        title={`Encuesta de satisfacción de: ${paciente?.nombre} ${paciente?.apellido_paterno} ${paciente?.apellido_materno}`}
      >
        <InfoField
        label='Ateción en recepción'
        value={encuestaSatisfaccion?.atencion_recpcion ?? 'N/A'}/>
        <InfoField
        label='trato del personal de enfermería'
        value={encuestaSatisfaccion?.trato_personal_enfermeria ?? 'N/A'}/>
        <InfoField
        label='Limpieza y comodidad de la habitación'
        value={encuestaSatisfaccion?.limpieza_comodidad_habitacion ?? 'N/A'}/>
        <InfoField
        label='Calidad de la comida'
        value={encuestaSatisfaccion?.calidad_comida ?? 'N/A'}/>
        <InfoField
        label='Tiempo de espera en tu ateción médica'
        value={encuestaSatisfaccion?.tiempo_atencion ?? 'N/A'}/>
        <InfoField
        label='¿Te sentiste bien informado(a) sobre tu procedimiento?'
        value={encuestaSatisfaccion?.informacion_tratamiento ?? 'N/A'}/>
        <InfoField
        label='¿Recibió atención nutricional?'
        value={encuestaSatisfaccion?.atencion_nutricional ?? 'N/A'}/>
        <InfoField
        label='Cometarios adicionales'
        value={encuestaSatisfaccion?.comentarios ?? 'N/A'}/>
      
      
      </InfoCard>

    </MainLayout>
  );

};
export default showEncuestaSatisfaccion;