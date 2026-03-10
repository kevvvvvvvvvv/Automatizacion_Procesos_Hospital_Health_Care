import { HojaEnfermeria } from '@/types'
import React from 'react'

import { DataTable } from '@/components/ui/data-table';
import { ControlLiquidos } from '@/types';

interface Props {
    hoja: HojaEnfermeria;
}


const SignosVitalesTable = ({ 
    hoja 
}: Props) => {

    console.log(hoja);

    const renderEgreso = (valor: number | null, descripcion: string | null) => {
        if (!valor && !descripcion) {
            return <span className="text-gray-400 text-sm">Sin registros</span>;
        }

        return (
            <div>
                {valor !== null && (
                    <div className="font-medium text-gray-900">{valor} ml</div>
                )}
                {descripcion && (
                    <div className="text-xs text-gray-500 italic leading-tight">
                        {descripcion}
                    </div>
                )}
            </div>
        );
    };

    const columnasControlLiquidos = [
        { 
            header: 'Fecha/Hora', 
            key: 'fecha_hora_registro',
            render: (reg: ControlLiquidos) => (
                <span className="text-sm text-gray-600">{reg.fecha_hora_registro}</span>
            )
        },
        { 
            header: 'Uresis', 
            key: 'uresis', 
            render: (reg: ControlLiquidos) => renderEgreso(reg.uresis, reg.uresis_descripcion)
        },
        { 
            header: 'Evacuaciones', 
            key: 'evacuaciones', 
            render: (reg: ControlLiquidos) => renderEgreso(reg.evacuaciones, reg.evacuaciones_descripcion)
        },
        { 
            header: 'Emesis', 
            key: 'emesis', 
            render: (reg: ControlLiquidos) => renderEgreso(reg.emesis, reg.emesis_descripcion)
        },
        { 
            header: 'Drenes', 
            key: 'drenes', 
            render: (reg: ControlLiquidos) => renderEgreso(reg.drenes, reg.drenes_descripcion)
        },
    ];

    return (
        <DataTable columns={columnasControlLiquidos} data={hoja.hoja_control_liquidos} />
    );
}

export default SignosVitalesTable;