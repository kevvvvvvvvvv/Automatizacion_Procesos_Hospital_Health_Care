import { HojaEnfermeria, HojaSondaCateter } from '@/types';
import React from 'react';

import { DataTable } from '@/components/ui/data-table';
import ContadorTiempo from '@/components/counter-time';

interface Props {
    hoja: HojaEnfermeria; 
}

const formatDateTime = (isoString: string | null) => {
    if (!isoString) return 'Pendiente';
    return new Date(isoString).toLocaleString('es-MX', {
        dateStyle: 'short',
        timeStyle: 'short',
    });
};

const SondasCateteresTable = ({ hoja }: Props) => {

    const columnasSondas = [
        {
            header: 'Dispositivo',
            key: 'dispositivo',
            render: (sonda: HojaSondaCateter) => (
                <span className="text-sm text-gray-900">
                    {sonda.producto_servicio?.nombre_prestacion || 'Desconocido'}
                </span>
            )
        },
        {
            header: 'F. instalación',
            key: 'fecha_instalacion',
            render: (sonda: HojaSondaCateter) => (
                <span className="text-sm text-gray-500">
                    {sonda.fecha_instalacion 
                        ? formatDateTime(sonda.fecha_instalacion) 
                        : 'No registrada'}
                </span>
            )
        },
        {
            header: 'Tiempo transcurrido',
            key: 'tiempo_transcurrido',
            render: (sonda: HojaSondaCateter) => (
                <span className="text-sm font-medium text-gray-900">
                    <ContadorTiempo 
                        fechaInicioISO={sonda.fecha_instalacion} 
                        fechaFinISO={sonda.fecha_caducidad} 
                    />
                </span>
            )
        },
        {
            header: 'F. caducidad',
            key: 'fecha_caducidad',
            render: (sonda: HojaSondaCateter) => (
                <span className="text-sm text-gray-500">
                    {sonda.fecha_caducidad 
                        ? formatDateTime(sonda.fecha_caducidad) 
                        : 'No registrada'}
                </span>
            )
        },
        {
            header: 'Observaciones',
            key: 'observaciones',
            render: (sonda: HojaSondaCateter) => (
                <div className="text-sm text-gray-500 truncate max-w-xs" title={sonda.observaciones}>
                    {sonda.observaciones || 'Sin observaciones'}
                </div>
            )
        }
    ];

    return (
        <DataTable 
            columns={columnasSondas} 
            data={hoja.sondas_activas_completas ?? []} 
        />
    );
}

export default SondasCateteresTable;