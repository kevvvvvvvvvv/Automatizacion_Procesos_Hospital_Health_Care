import { HojaEnfermeria } from '@/types'
import React from 'react'

import { DataTable } from '@/components/ui/data-table';
import { HojaSignos } from '@/types';

interface Props {
    hoja: HojaEnfermeria;
}


const SignosVitalesTable = ({ 
    hoja 
}: Props) => {

    const columnasSignos = [
        { 
            header: 'Fecha/Hora', 
            key: 'fecha_hora_registro' 
        },
        { 
            header: 'T.A.', 
            key: 'tension', 
            render: (reg: HojaSignos) => reg.tension_arterial_sistolica ? `${reg.tension_arterial_sistolica} / ${reg.tension_arterial_diastolica} mmHg` : 'Sin registros' 
        },
        { 
            header: 'F.C.', 
            key: 'frecuencia_cardiaca', 
            render: (reg: HojaSignos) => reg.frecuencia_cardiaca ? `${reg.frecuencia_cardiaca} ppm` : 'Sin registros' 
        },
        { 
            header: 'F.R.', 
            key: 'frecuencia_respiratoria', 
            render: (reg: HojaSignos) => reg.frecuencia_respiratoria ? `${reg.frecuencia_respiratoria} rpm` : 'Sin registros' 
        },
        { 
            header: 'Temp', 
            key: 'temperatura', 
            render: (reg: HojaSignos) => reg.temperatura ? `${reg.temperatura} °C` : 'Sin registros'
        },
        { 
            header: 'S.O.', 
            key: 'saturacion_oxigeno', 
            render: (reg: HojaSignos) => reg.saturacion_oxigeno ? `${reg.saturacion_oxigeno} %` : 'Sin registros'  
        },
        { 
            header: 'G.C.', 
            key: 'glucemia_capilar', 
            render: (reg: HojaSignos) => reg.glucemia_capilar ? `${reg.glucemia_capilar} mg/dL` : 'Sin registros' 
        },
        { 
            header: 'Talla', 
            key: 'talla', 
            render: (reg: HojaSignos) => reg.talla ? `${reg.talla} cm` : 'Sin registros' 
        },
        { 
            header: 'Peso', 
            key: 'peso',             
            render:  (reg: HojaSignos) => reg.peso ? `${reg.peso} kg` : 'Sin registros'
        },
    ];


    return (
        <DataTable columns={columnasSignos} data={hoja.hoja_signos} />
    );
}

export default SignosVitalesTable;