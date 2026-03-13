import { HojaEnfermeria, SolicitudEstudio } from '@/types'
import React from 'react'

import { DataTable } from '@/components/ui/data-table';

interface Props {
    hoja: HojaEnfermeria;
}


const SignosVitalesTable = ({ 
    hoja 
}: Props) => {

    const columnasSolicitudEstudio = [
        { 
            header: 'Fecha/Hora', 
            key: 'created_at',
            render: (reg: SolicitudEstudio) => reg.created_at 
                ? new Date(reg.created_at).toLocaleString() 
                : 'Sin registros'
        },
        { 
            header: 'Estudios solicitados', 
            key: 'solicitud_items', 
            render: (reg: SolicitudEstudio) => {
                if (!reg.solicitud_items || reg.solicitud_items.length === 0) {
                    return <span className="text-gray-400 italic">Sin estudios</span>;
                }

                return (
                    <div className="flex flex-col space-y-1">
                        {reg.solicitud_items.map((soli, index) => (
                            <p key={soli.id || index} className="text-sm text-gray-700">
                                <span className="font-medium">
                                    • {soli.catalogo_estudio?.nombre || 'Estudio desconocido'}
                                </span>
                                {soli.estado && (
                                    <span className="ml-2 text-xs text-blue-600">({soli.estado})</span>
                                )}
                            </p>
                        ))}
                    </div>
                );
            }
        },
    ];

    return (
        <DataTable columns={columnasSolicitudEstudio} data={hoja.solicitudes_estudio} />
    );
}

export default SignosVitalesTable;