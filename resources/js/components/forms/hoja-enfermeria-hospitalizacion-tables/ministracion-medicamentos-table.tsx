import { HojaEnfermeria } from '@/types'
import React from 'react'

import { DataTable } from '@/components/ui/data-table';
import { HojaMedicamento } from '@/types';

interface Props {
    hoja: HojaEnfermeria;
}


const SignosVitalesTable = ({ 
    hoja 
}: Props) => {

    const columnaMedicamentos = [
        { 
            header: 'Nombre del medicamento', 
            key: 'nombre_medicamento', 
            render: (reg: HojaMedicamento) => reg.nombre_medicamento ? `${reg.nombre_medicamento}` : 'Sin registros' 
        },
        { 
            header: 'Dosis', 
            key: 'dosis', 
            render: (reg: HojaMedicamento) => reg.dosis ? `${reg.dosis}` : 'Sin registros' 
        },
        { 
            header: 'Duración (frecuencia)', 
            key: 'duracion', 
            render: (reg: HojaMedicamento) => reg.duracion_tratamiento ? `${reg.duracion_tratamiento}` : 'Sin registros' 
        },
        { 
            header: 'Via administración', 
            key: 'via_administracion', 
            render: (reg: HojaMedicamento) => reg.via_administracion ? `${reg.via_administracion}` : 'Sin registros' 
        },
        { 
            header: 'Fecha de aplicación', 
            key: 'fecha_aplicacion', 
            render: (reg: HojaMedicamento) => {
                return (
                    reg.aplicaciones.map((app, index) => (
                        <p key={index}>{app.fecha_aplicacion}</p>
                    ))
                );
            }
        },

    ];


    return (
        <DataTable columns={columnaMedicamentos} data={hoja.hoja_medicamentos} />
    );
}

export default SignosVitalesTable;