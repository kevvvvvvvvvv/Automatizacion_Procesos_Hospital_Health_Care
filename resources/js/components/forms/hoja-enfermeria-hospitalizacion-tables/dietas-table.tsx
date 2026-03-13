import { HojaEnfermeria, SolicitudDieta } from '@/types'
import React from 'react'

import { DataTable } from '@/components/ui/data-table';

interface Props {
    hoja: HojaEnfermeria;
}


const SignosVitalesTable = ({ 
    hoja 
}: Props) => {

   const columnasDietas = [
        { 
            header: 'Tipo de Dieta', 
            key: 'tipo_dieta',
            render: (reg: SolicitudDieta) => (
            <div>
                <div className="font-bold text-gray-900">{reg.dieta.categoria_dieta.categoria}</div>
                <div className="text-xs text-gray-500">{}</div>
            </div>
            )
        },
        { 
            header: 'Solicitud', 
            key: 'horario_solicitud',
            render: (reg: SolicitudDieta) => (
            <div className="text-xs">
                <span className="block font-medium">Hora del pedido: {reg.horario_solicitud}</span>
                <span className="text-gray-400">Supervisa: {reg.user_supervisa?.nombre || 'Pendiente'}</span>
            </div>
            )
        },
        { 
            header: 'Información de entrega', 
            key: 'informacion_entrega',
            render: (reg: SolicitudDieta) => (
            <div className="text-xs">
                <>
                    <span className="block font-medium">Horario de entrega programado: {reg.fecha_hora_programada ? reg.fecha_hora_programada : 'N/A'}</span>
                    <span className="text-gray-400 font font-medium">Área de entrega: {reg.lugar_entrega}</span>
                </>
            </div>
            )
        },
        { 
            header: 'Entrega', 
            key: 'horario_entrega',
            render: (reg: SolicitudDieta) => (
            <div className="text-xs">
                {reg.horario_entrega ? (
                <>
                    <span className="block text-green-600 font-medium">Entregado: {reg.horario_entrega}</span>
                    <span className="text-gray-400">ID Entrega: {reg.user_entrega_id}</span>
                </>
                ) : (
                <span className="text-amber-500 italic">En proceso...</span>
                )}
            </div>
            )
        },
    ];

    return (
        <DataTable columns={columnasDietas} data={hoja.solicitudes_dieta} />
    );
}

export default SignosVitalesTable;