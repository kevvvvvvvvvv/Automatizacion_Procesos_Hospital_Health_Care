import { HojaEnfermeria } from '@/types'
import React from 'react'

import { DataTable } from '@/components/ui/data-table';
import { HojaTerapiaIV } from '@/types';

interface Props {
    hoja: HojaEnfermeria;
}


const SignosVitalesTable = ({ 
    hoja 
}: Props) => {

    const columnasTerapias = [
        { 
            header: 'Fecha/Hora', 
            key: 'fecha_hora_registro',
            render: (reg: HojaTerapiaIV) => {
                if (!reg.created_at) return 'Sin registros';
                
                const fecha = new Date(reg.created_at);
                
                return fecha.toLocaleString('es-MX', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true 
                });
            }  
        },
        { 
            header: 'Solución', 
            key: 'solucion', 
            render: (reg: HojaTerapiaIV) => (
                <>
                    <p className='text-gray-900 text-sm'>
                        {reg.nombre_solucion ? `${reg.nombre_solucion}` : 'Sin registros' }
                    </p>
                    <div>
                        {reg.medicamentos && (
                            reg.medicamentos.map((med) => (
                                <div className='text-gray-600 text-xs'>
                                    {med.nombre_medicamento } | {med.dosis} {med.unidad_medida}
                                </div>
                            ))
                        )}
                    </div>
                </>
                
            )
        },
        { 
            header: 'Cantidad', 
            key: 'cantidad', 
            render: (reg: HojaTerapiaIV) => reg.cantidad ? `${reg.cantidad}` : 'Sin registros' 
        },
        { 
            header: 'Duración', 
            key: 'duracion', 
            render: (reg: HojaTerapiaIV) => reg.duracion ? `${reg.duracion}` : 'Sin registros' 
        },
        { 
            header: 'Flujo (ml/hr)', 
            key: 'flujo_ml_hr', 
            render: (reg: HojaTerapiaIV) => reg.flujo_ml_hora ? `${reg.flujo_ml_hora}` : 'Sin registros' 
        },
        { 
            header: 'Fecha/hora inicio', 
            key: 'fecha_hora_inicio', 
            render: (reg: HojaTerapiaIV) => reg.fecha_hora_inicio ? `${reg.fecha_hora_inicio}` : 'Sin registros' 
        },
    ];


    return (
        <DataTable columns={columnasTerapias} data={hoja.hojas_terapia_i_v} />
    );
}

export default SignosVitalesTable;