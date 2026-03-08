import { HojaEnfermeria } from '@/types'
import React from 'react'

import { DataTable } from '@/components/ui/data-table';
import { HojaRiesgoCaida } from '@/types';

interface Props {
    hoja: HojaEnfermeria;
}


const SignosVitalesTable = ({ 
    hoja 
}: Props) => {

    const columnasRiesgoCaidas = [
        { 
            header: 'Fecha', 
            key: 'created_at',
            render: (reg: HojaRiesgoCaida) => (
                <span className="text-sm text-gray-600">
                    {new Date(reg.created_at).toLocaleString('es-MX', { dateStyle: 'short', timeStyle: 'short' })}
                </span>
            )
        },
        { 
            header: 'Estado Mental', 
            key: 'estado_mental',
            render: (reg: HojaRiesgoCaida) => (
                <span className={`capitalize ${reg.estado_mental === 'confuso' ? 'text-red-600 font-bold' : ''}`}>
                    {reg.estado_mental}
                </span>
            )
        },
        { 
            header: 'Deambulación', 
            key: 'deambulacion',
            render: (reg: HojaRiesgoCaida) => <span className="capitalize">{reg.deambulacion.replace('_', ' ')}</span>
        },
        { 
            header: 'Medicamentos', 
            key: 'medicamentos', 
            render: (reg: HojaRiesgoCaida) => (
                <div className="flex flex-wrap gap-1 max-w-xs">
                    {reg.medicamentos.length > 0 ? (
                        reg.medicamentos.map((med, i) => (
                            <span key={i} className="px-2 py-0.5 bg-yellow-100 text-yellow-800 text-[10px] rounded-full border border-yellow-200">
                                {med}
                            </span>
                        ))
                    ) : (
                        <span className="text-gray-400 text-xs">Ninguno</span>
                    )}
                </div>
            )
        },
        { 
            header: 'Déficits', 
            key: 'deficits', 
            render: (reg: HojaRiesgoCaida) => (
                <div className="flex flex-wrap gap-1 max-w-xs">
                    {reg.deficits.length > 0 ? (
                        reg.deficits.map((def, i) => (
                            <span key={i} className="px-2 py-0.5 bg-blue-100 text-blue-800 text-[10px] rounded-full border border-blue-200">
                                {def}
                            </span>
                        ))
                    ) : (
                        <span className="text-gray-400 text-xs">Ninguno</span>
                    )}
                </div>
            )
        },
        { 
            header: 'Puntaje', 
            key: 'puntaje_total', 
            render: (reg: HojaRiesgoCaida) => {
                const nivelRiesgo = reg.puntaje_total >= 3 ? 'Alto Riesgo' : 'Riesgo Bajo';
                const color = reg.puntaje_total >= 3 ? 'bg-red-500' : 'bg-green-500';
                return (
                    <div className="flex flex-col items-center">
                        <span className={`text-white px-2 py-1 rounded text-xs font-bold ${color}`}>
                            {reg.puntaje_total} pts
                        </span>
                        <span className="text-[10px] text-gray-500 mt-1">{nivelRiesgo}</span>
                    </div>
                );
            }
        }
    ];

    return (
        <div className="mt-12">
            <DataTable columns={columnasRiesgoCaidas} data={hoja.hoja_riesgo_caida} />
        </div>
    );
}

export default SignosVitalesTable;