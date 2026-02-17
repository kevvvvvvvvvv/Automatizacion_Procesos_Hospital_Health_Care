import { SolicitudDieta } from '@/types';
import React from 'react';
import { route } from 'ziggy-js';
import { Head } from '@inertiajs/react'; 

import MainLayout from '@/layouts/MainLayout';

interface Props {
    solicitud_dietas: Record<number, SolicitudDieta[]>;
}

const Index = ({
    solicitud_dietas = {},
}: Props) => {

const grupos = Object.entries(solicitud_dietas);

    return (
        <MainLayout
            pageTitle='Solicitudes de dietas'
            link='dashboard'
        >
            <Head
                title='Solicitudes de dietas'
            />
            <div className="p-6">
                {grupos.length > 0 ? (
                    grupos.map(([estanciaId, dietas]) => (
                        <div key={estanciaId} className="mb-8 border rounded-lg overflow-hidden">
                            <div className="bg-gray-100 p-3 font-bold border-b">
                                Estancia ID: {estanciaId} 
                                <span className="ml-4 text-sm font-normal text-gray-600">
                                    ({dietas.length} solicitudes)
                                </span>
                            </div>
                            
                            <table className="w-full text-left">
                                <thead className="bg-white border-b">
                                    <tr>
                                        <th className="p-3">ID</th>
                                        <th className="p-3">Dieta</th>
                                        <th className="p-3">Horario solicitud</th>
                                        <th className="p-3">Observaciones</th>
                                        <th className='p-3'>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {dietas.map((dieta) => (
                                        <tr key={dieta.id} className="border-b hover:bg-gray-50">
                                            <td className="p-3">{dieta.id}</td>
                                            <td className="p-3">{dieta.dieta_id}</td>
                                            <td className="p-3">{dieta.horario_solicitud}</td>
                                            <td className="p-3 text-gray-500 italic">
                                                {dieta.observaciones || 'Sin notas'}
                                            </td>
                                            <td>
                                                <a href={route('solicitudes-dietas.show', {estancia: dieta.hoja_enfermeria.formulario_instancia.estancia_id})}>Ir a </a>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    ))
                ) : (
                    <p className="text-center text-gray-500">No hay dietas pendientes hoy.</p>
                )}
            </div>            
            
        </MainLayout>

    );
} 

export default Index;