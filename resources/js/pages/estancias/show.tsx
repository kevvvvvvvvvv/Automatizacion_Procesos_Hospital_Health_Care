import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { Estancia, Paciente, User } from '@/types';
import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';
import AddButton from '@/components/ui/add-button';
import {route} from 'ziggy-js';

interface ShowEstanciaProps {
    estancia: Estancia;
    paciente: Paciente;
    creator: User | null;
    updater: User | null;
}

const Show = ({ estancia, paciente, creator, updater }: ShowEstanciaProps) => {
    return (
        <>
            <Head title={`Detalles de estancia: ${estancia.folio}`} />

            <InfoCard title={`Estancia para: ${paciente.nombre} ${paciente.apellido_paterno}`}>
                <div className="grid grid-cols-2 gap-4">
                    <InfoField label="Folio" value={estancia.folio} />
                    <InfoField label="Fecha de Ingreso" value={estancia.fecha_ingreso} />
                    <InfoField label="Fecha de egreso" value={estancia.fecha_egreso} />
                    <InfoField label="Número de habitación" value={estancia.num_habitacion} />
                    <InfoField label="Tipo de estancia" value={estancia.tipo_estancia} />
                    <InfoField label="Creado por" value={creator ? creator.nombre : 'N/A'} />
                    <InfoField 
                        label="Última actualización por" 
                        value={updater ? updater.nombre : 'N/A'} 
                    />
                </div>
            </InfoCard>
            <AddButton href={route('pacientes.estancias.hojasfrontales.create', { paciente: paciente.id, estancia:estancia.id })}>
                Hoja frontal
            </AddButton>

            
        </>
    );
};

Show.layout = (page: React.ReactElement) => {
    const { paciente } = page.props as ShowEstanciaProps;
    return (
        <MainLayout title={`Detalles de estancia de ${paciente.nombre}`} children={page} />
    );
};

export default Show;