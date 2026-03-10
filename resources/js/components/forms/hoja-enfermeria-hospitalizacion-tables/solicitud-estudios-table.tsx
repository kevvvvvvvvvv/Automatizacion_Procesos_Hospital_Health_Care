import { HojaEnfermeria, HojaEscalaValoracion } from '@/types'
import React from 'react'

import { DataTable } from '@/components/ui/data-table';

interface Props {
    hoja: HojaEnfermeria;
}


const SignosVitalesTable = ({ 
    hoja 
}: Props) => {

    const columnasEscalaValoracion = [
        { 
            header: 'Fecha/Hora', 
            key: 'fecha_hora_registro' 
        },
        { 
            header: 'Escala Braden', 
            key: 'escala_braden', 
            render: (reg: HojaEscalaValoracion ) => reg.escala_braden ? `${reg.escala_braden} ` : 'Sin registros' 
        },
        { 
            header: 'Escala Glasgow', 
            key: 'escala_glasgow', 
            render: (reg: HojaEscalaValoracion) => reg.escala_glasgow ? `${reg.escala_glasgow}` : 'Sin registros' 
        },
        { 
            header: 'Escala Ramsey', 
            key: 'escala_ramsey', 
            render: (reg: HojaEscalaValoracion) => reg.escala_ramsey ? `${reg.escala_ramsey}` : 'Sin registros' 
        },
        { 
            header: 'Valoración de dolor', 
            key: 'valoracion_dolor', 
            render: (reg: HojaEscalaValoracion) => {
                if (!reg.valoracion_dolor || reg.valoracion_dolor.length === 0) {
                    return <span className="text-gray-400 italic text-sm">Sin dolor</span>;
                }

                return (
                    <div className="flex flex-col space-y-1">
                        {reg.valoracion_dolor.map((dolor, index) => (
                            <p key={index} className="text-sm text-gray-700">
                                <span className="font-medium">EVA {dolor.escala_eva}:</span> {dolor.ubicacion_dolor}
                            </p>
                        ))}
                    </div>
                );
            }
        },
    ];

    return (
        <DataTable columns={columnasEscalaValoracion} data={hoja.hoja_escala_valoraciones} />
    );
}

export default SignosVitalesTable;