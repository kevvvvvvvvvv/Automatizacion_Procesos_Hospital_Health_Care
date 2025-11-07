import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Pencil, Printer } from 'lucide-react';
import { route } from 'ziggy-js';
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
        <MainLayout>
            <Head title={`Traslado ${traslado.id}`} />
            <InfoCard title={`Detalles del Traslado para: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <InfoField label="Tensión Arterial" value={traslado.ta || 'N/A'} />
                    <InfoField label="Frecuencia Cardíaca" value={traslado.fc ? traslado.fc.toString() : 'N/A'} />
                    <InfoField label="Frecuencia Respiratoria" value={traslado.fr ? traslado.fr.toString() : 'N/A'} />
                    <InfoField label="Temperatura" value={traslado.temp ? traslado.temp.toString() : 'N/A'} />
                    <InfoField label="Glucometria capilar" value={traslado.dxtx ? traslado.dxtx.toString() : 'N/A'} />
                </div>
                <div className="p-4 md:p-8">
                    <h1 className="text-2xl font-bold mb-4">{`Traslado #${traslado.id} de ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}</h1>
                    <InfoField label ="Unidad Médica que Envía" value={traslado.unidad_medica_envia || 'N/A'} />
                    <InfoField label ="Motivo del Traslado" value={traslado.motivo_translado || 'N/A'} />
                    <InfoField label ="Unidad Médica que Recibe" value={traslado.unidad_medica_recibe || 'N/A'} />
                    <InfoField label ="Resumen Clínico" value={traslado.resumen_clinico || 'N/A'} />
                    <InfoField label ="Tratamiento Terapéutico Administrado" value={traslado.tratamiento_terapeutico_administrada || 'N/A'} /> 
                </div>
            </InfoCard>
        </MainLayout>
    );
};

export default Show;