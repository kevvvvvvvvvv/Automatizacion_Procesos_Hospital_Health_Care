import React from 'react';
import { useForm } from '@inertiajs/react';
import { HojaEnfermeria, HojaSignos } from '@/types'; 
import { route } from 'ziggy-js';
import { Pencil } from 'lucide-react'; 

import InputText from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';
import { DataTable } from '../ui/data-table';
import Swal from 'sweetalert2';

interface Props {
    hoja: HojaEnfermeria;
}

const SignosVitalesForm: React.FC<Props> = ({ hoja }) => {

    const { data, setData, post, processing, errors, reset } = useForm({
        fecha_hora_registro: new Date().toISOString().slice(0, 16), 
        tension_arterial_sistolica: '',
        tension_arterial_diastolica: '',
        frecuencia_cardiaca: '',
        frecuencia_respiratoria: '',
        temperatura: '',
        saturacion_oxigeno: '',
        glucemia_capilar: '',
        peso: '',
        talla: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        Swal.fire({
            title: '¿Confirmar registro?',
            text: "Se guardarán los signos vitales capturados.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                post(route('hojassignos.store', { hojasenfermeria: hoja.id }), {
                    preserveScroll: true,
                    onSuccess: ()=>{
                        reset();
                    }
                });
            }
        });
    }

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
        {
            header: 'Acción',
            key: 'accion',
            render: (reg: HojaSignos) => (
            <button 
                onClick={() => console.log("Editar registro:", reg.id)} 
                className="text-blue-600 hover:text-blue-900"
            >
                <Pencil size={18} />
            </button>
            )
        }
    ];

    return (
        <>
            <form onSubmit={handleSubmit}>
                <h2 className='mb-5 font-bold text-xl'>Tensión arterial</h2>
                <div className="grid grid-cols-3 md:grid-cols-6 items-center gap-1">
                    <InputText 
                        id="tension_arterial_sistolica" 
                        name="tension_arterial_sistolica" 
                        label="Sistólica" 
                        type="number"
                        value={data.tension_arterial_sistolica} 
                        onChange={(e) => setData('tension_arterial_sistolica', e.target.value)} 
                        error={errors.tension_arterial_sistolica} 
                    />

                    <span className="text-center">/</span>

                    <InputText 
                        id="tension_arterial_diastolica" 
                        name="tension_arterial_diastolica" 
                        label="Diastólica" 
                        type="number"
                        value={data.tension_arterial_diastolica} 
                        onChange={(e) => setData('tension_arterial_diastolica', e.target.value)} 
                        error={errors.tension_arterial_diastolica} 
                    />
                </div>

                <div className="grid grid-cols-2 md:grid-cols-3 gap-6">

                    <InputText 
                        id="frecuencia_cardiaca" 
                        name="frecuencia_cardiaca" 
                        label="Frecuencia cardíaca (por minuto)" 
                        type="number" 
                        value={data.frecuencia_cardiaca} 
                        onChange={(e) => setData('frecuencia_cardiaca', e.target.value)} 
                        error={errors.frecuencia_cardiaca} 
                    />
                    
                    <InputText 
                        id="frecuencia_respiratoria" 
                        name="frecuencia_respiratoria" 
                        label="Frecuencia respiratoria (por minuto)" 
                        type="number" 
                        value={data.frecuencia_respiratoria} 
                        onChange={(e) => setData('frecuencia_respiratoria', e.target.value)} 
                        error={errors.frecuencia_respiratoria} 
                    />
                    <InputText 
                        id="temperatura" 
                        name="temperatura" 
                        label="Temperatura (Celsius)" 
                        type="number"
                        value={data.temperatura} 
                        onChange={(e) => setData('temperatura', e.target.value)} 
                        error={errors.temperatura} 
                    />
                    <InputText 
                        id="saturacion_oxigeno" 
                        name="saturacion_oxigeno" 
                        label="Saturación de oxígeno (%)" 
                        type="number" 
                        value={data.saturacion_oxigeno} 
                        onChange={(e) => setData('saturacion_oxigeno', e.target.value)} 
                        error={errors.saturacion_oxigeno} 
                    />
                    <InputText 
                        id="glucemia_capilar" 
                        name="glucemia_capilar" 
                        label="Glucemia capilar (mg/dL)" 
                        type="number" 
                        value={data.glucemia_capilar} 
                        onChange={(e) => setData('glucemia_capilar', e.target.value)} 
                        error={errors.glucemia_capilar} 
                    />
                    <InputText 
                        id="peso" 
                        name="peso" 
                        label="Peso (kg)" 
                        type="number"
                        value={data.peso} 
                        onChange={(e) => setData('peso', e.target.value)} 
                        error={errors.peso} 
                    />
                    <InputText 
                        id="talla" 
                        name="talla" 
                        label="Talla (cm)" 
                        type="number" 
                        value={data.talla} 
                        onChange={(e) => setData('talla', e.target.value)} 
                        error={errors.talla} 
                    />
                    
                </div>

                <div className="flex justify-end mt-6">
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </form>
            <div className="mt-12">
                <DataTable columns={columnasSignos} data={hoja.hoja_signos} />
            </div>
        </>
    );
}

export default SignosVitalesForm;