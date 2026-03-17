import React from 'react';
import { HojaEnfermeria, HojaHabitusExterior } from '@/types';

import { DataTable } from '@/components/ui/data-table';

interface Props {
    hoja: HojaEnfermeria;
}

const HabitusExteriorTable = ({ hoja }: Props) => {

    const formatText = (text: string | null | undefined) => {
        if (!text) return '-';
        const conEspacios = text.replace(/_/g, ' ');
        return conEspacios.charAt(0).toUpperCase() + conEspacios.slice(1);
    };

    const columnasHabitus = [
        {
            header: 'Registro',
            key: 'created_at',
            render: (habitus: HojaHabitusExterior) => (
                <span className="text-sm text-gray-500 whitespace-nowrap">
                    {habitus.created_at ? new Date(habitus.created_at).toLocaleString() : 'No registrada'}
                </span>
            )
        },
        {
            header: 'Sexo / Edad',
            key: 'sexo_edad',
            render: (habitus: HojaHabitusExterior) => (
                <span className="text-sm font-medium text-gray-900 whitespace-nowrap">
                    {formatText(habitus.sexo)} / {formatText(habitus.edad_aparente)}
                </span>
            )
        },
        {
            header: 'Condición llegada',
            key: 'condicion_llegada',
            render: (habitus: HojaHabitusExterior) => (
                <span className="text-sm text-gray-900">
                    {formatText(habitus.condicion_llegada)}
                </span>
            )
        },
        {
            header: 'Estado Neurológico',
            key: 'neurologico',
            render: (habitus: HojaHabitusExterior) => (
                <div className="flex flex-col text-sm text-gray-900 space-y-1" style={{ minWidth: '180px' }}>
                    <span><span className="font-semibold text-gray-600">Conciencia:</span> {formatText(habitus.estado_conciencia)}</span>
                    <span><span className="font-semibold text-gray-600">Orientación:</span> {formatText(habitus.orientacion)}</span>
                    <span><span className="font-semibold text-gray-600">Lenguaje:</span> {formatText(habitus.lenguaje)}</span>
                </div>
            )
        },
        {
            header: 'Físico / Postura',
            key: 'fisico_postura',
            render: (habitus: HojaHabitusExterior) => (
                <div className="flex flex-col text-sm text-gray-900 space-y-1" style={{ minWidth: '180px' }}>
                    <span><span className="font-semibold text-gray-600">Facies:</span> {formatText(habitus.facies)}</span>
                    <span><span className="font-semibold text-gray-600">Postura:</span> {formatText(habitus.postura)}</span>
                    <span><span className="font-semibold text-gray-600">Constitución:</span> {formatText(habitus.constitucion)}</span>
                </div>
            )
        },
        {
            header: 'Evaluación General',
            key: 'evaluacion_general',
            render: (habitus: HojaHabitusExterior) => (
                <div className="flex flex-col text-sm text-gray-900 space-y-1" style={{ minWidth: '180px' }}>
                    <span><span className="font-semibold text-gray-600">Piel:</span> {formatText(habitus.piel)}</span>
                    <span><span className="font-semibold text-gray-600">Higiene:</span> {formatText(habitus.higiene)}</span>
                    <span><span className="font-semibold text-gray-600">Olor/Ruido:</span> {formatText(habitus.olores_ruidos)}</span>
                </div>
            )
        },
        {
            header: 'Movilidad',
            key: 'movilidad',
            render: (habitus: HojaHabitusExterior) => (
                <div className="flex flex-col text-sm text-gray-900 space-y-1">
                    <span><span className="font-semibold text-gray-600">Marcha:</span> {formatText(habitus.marcha)}</span>
                    <span><span className="font-semibold text-gray-600">Movs:</span> {formatText(habitus.movimientos)}</span>
                </div>
            )
        }
    ];

    return (
        <DataTable 
            columns={columnasHabitus} 
            data={hoja.hoja_habitus_exterior ?? []} 
        />
    );
}

export default HabitusExteriorTable;