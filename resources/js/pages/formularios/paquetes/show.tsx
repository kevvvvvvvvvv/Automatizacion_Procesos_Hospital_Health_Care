import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { Paciente, Estancia, User } from '@/types'; // Asegúrate de tener estas interfaces

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface Paquete {
    id: number;
    catalogo_estudio_id?: number;
    catalogo_estudio?: { nombre: string };
    otro_estudio?: string;
    departamento_destino: string;
    estado: string;
}

interface SolicitudEstudio {
    id: number;
    estado: string;
    user_solicita?: User;
    user_llena?: User;
    paquetes: Paquete[];
    created_at: string;
}

interface ShowProps {
    solicitud: SolicitudEstudio;
    paciente: Paciente;
    estancia: Estancia;
}

const Show = ({ solicitud, paciente, estancia }: ShowProps) => {
    return (
        <MainLayout
            pageTitle={`Solicitud de Estudios`}
            link='estancias.show'
            linkParams={estancia.id}
        >
            <Head title={`Solicitud de Estudios ${solicitud.id}`} />

            <InfoCard
                title={`Solicitud de Estudios: ${paciente.nombre} ${paciente.apellido_paterno}`}
            >
                {/* Información de la Solicitud */}
                <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full">
                    Datos Generales de la Solicitud
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <InfoField
                        label="Médico Solicitante"
                        value={solicitud.user_solicita?.nombre_completo ?? 'N/A'}
                    />
                    <InfoField
                        label="Fecha de Solicitud"
                        value={new Date(solicitud.created_at).toLocaleString()}
                    />
                    <InfoField
                        label="Estado General"
                        value={solicitud.estado}
                    />
                    <InfoField
                        label="Personal que Registra"
                        value={solicitud.user_llena?.nombre_completo ?? 'N/A'}
                    />
                </div>

                {/* Listado de Estudios Seleccionados */}
                <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full border-t pt-4">
                    Exámenes y Estudios Solicitados
                </h2>
                
                <div className="col-span-full space-y-4">
                    {solicitud.paquetes.map((item, index) => (
                        <div 
                            key={item.id} 
                            className="p-3 border rounded-lg bg-gray-50 flex flex-col md:flex-row md:justify-between md:items-center"
                        >
                            <div className="flex-1">
                                <span className="text-sm font-bold text-blue-600 uppercase tracking-wide">
                                    Estudio #{index + 1}
                                </span>
                                <p className="text-md font-medium text-gray-900">
                                    {/* Muestra el nombre del catálogo o el nombre manual */}
                                    {item.catalogo_estudio?.nombre || item.otro_estudio}
                                </p>
                            </div>
                            
                            <div className="grid grid-cols-2 gap-4 mt-2 md:mt-0 md:text-right">
                                <InfoField 
                                    label="Departamento" 
                                    value={item.departamento_destino} 
                                />
                                <InfoField 
                                    label="Estado Item" 
                                    value={item.estado} 
                                />
                            </div>
                        </div>
                    ))}

                    {solicitud.paquetes.length === 0 && (
                        <p className="text-gray-500 italic">No hay estudios registrados en esta solicitud.</p>
                    )}
                </div>
            </InfoCard>
        </MainLayout>
    );
};



export default Show;