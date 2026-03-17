import React from 'react';
import { HojaEnfermeria, HojaEnfermeriaQuirofano, HojaOxigeno } from '@/types';

import { DataTable } from '@/components/ui/data-table';
import ContadorTiempo from '@/components/counter-time';

interface Props {
    modelo: HojaEnfermeria | HojaEnfermeriaQuirofano; 
}

const HojaOxigenoTable = ({ modelo }: Props) => {

    const columnasOxigeno = [
        {
            header: 'Hora de inicio',
            key: 'hora_inicio',
            render: (oxi: HojaOxigeno) => (
                <span className="text-sm text-gray-900">
                    {oxi.hora_inicio || 'No registrada'}
                </span>
            )
        },
        {
            header: 'Tiempo transcurrido',
            key: 'tiempo_transcurrido',
            render: (oxi: HojaOxigeno) => (
                <span className="text-sm text-gray-900">
                    <ContadorTiempo
                        fechaInicioISO={oxi.hora_inicio}
                        fechaFinISO={oxi.hora_fin}
                    />
                </span>
            )
        },
        {
            header: 'Hora de fin',
            key: 'hora_fin',
            render: (oxi: HojaOxigeno) => (
                <span className="text-sm text-gray-500">
                    {oxi.hora_fin ? (
                        <span className="text-gray-900">{oxi.hora_fin}</span>
                    ) : (
                        <span className="italic">En curso...</span>
                    )}
                </span>
            )
        },
        {
            header: 'Litros por minuto',
            key: 'litros_minuto',
            render: (oxi: HojaOxigeno) => (
                <span className="text-sm text-gray-900">
                    {oxi.litros_minuto ? `${oxi.litros_minuto} L/min` : '-'}
                </span>
            )
        },
        {
            header: 'Total consumido',
            key: 'total_consumido',
            render: (oxi: HojaOxigeno) => (
                <span className="text-sm text-gray-900">
                    {oxi.total_consumido ? `${oxi.total_consumido} L` : '-'}
                </span>
            )
        },
        {
            header: 'Personal que inició',
            key: 'personal_inicio',
            render: (oxi: HojaOxigeno) => {
                if (!oxi.user_inicio) return <span className="text-sm text-gray-500">Desconocido</span>;
                const nombreCompleto = `${oxi.user_inicio.nombre} ${oxi.user_inicio.apellido_paterno} ${oxi.user_inicio.apellido_materno || ''}`.trim();              
                return <span className="text-sm text-gray-900">{nombreCompleto}</span>;
            }
        },
        {
            header: 'Personal que finalizó',
            key: 'personal_fin',
            render: (oxi: HojaOxigeno) => {
                if (!oxi.user_fin) return <span className="text-sm text-gray-500 italic">Pendiente</span>;
                
                const nombreCompleto = `${oxi.user_fin.nombre} ${oxi.user_fin.apellido_paterno} ${oxi.user_fin.apellido_materno || ''}`.trim();
                
                return <span className="text-sm text-gray-900">{nombreCompleto}</span>;
            }
        }
    ];

    return (
        <DataTable 
            columns={columnasOxigeno} 
            data={modelo.oxigeno_activo ?? []} 
        />
    );
}

export default HojaOxigenoTable;