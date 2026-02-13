import React, { useEffect } from 'react';
import { useForm } from '@inertiajs/react';
import { HojaEnfermeria, HojaRiesgoCaida } from '@/types';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

import PrimaryButton from '../ui/primary-button';
import SelectInput from '../ui/input-select';
import Checkbox from '../ui/input-checkbox';
import {DataTable} from '../ui/data-table';

interface Props {
    hoja: HojaEnfermeria;
}


const medicamentosList = [
    { id: 'tranquilizantes', label: 'Tranquilizantes / Sedantes' },
    { id: 'diureticos', label: 'Diuréticos' },
    { id: 'hipotensores', label: 'Hipotensores (no diuréticos)' },
    { id: 'antiparkinsonianos', label: 'Antiparkinsonianos' },
    { id: 'antidepresivos', label: 'Antidepresivos' },
    { id: 'otros', label: 'Otros medicamentos de riesgo' },
];

const deficitList = [
    { id: 'visuales', label: 'Alteraciones visuales' },
    { id: 'auditivas', label: 'Alteraciones auditivas' },
    { id: 'extremidades', label: 'Extremidades (parálisis/paresia)' },
];

const RiesgoCaidasForm = ({ hoja }: Props) => {
    

    const { data, setData, post, processing, reset } = useForm({
        caidas_previas: '0', 
        estado_mental: 'orientado',
        deambulacion: 'normal',
        edad_mayor_70: false, 

        medicamentos: [] as string[], 
        deficits: [] as string[],
        
        puntaje_total: 0,
    });

    const handleMultiCheckboxChange = (field: 'medicamentos' | 'deficits', value: string, checked: boolean) => {
        let currentArray = [...data[field]] as string[];
        
        if (checked) {
            currentArray.push(value);
        } else {
            currentArray = currentArray.filter(item => item !== value);
        }
        
        setData(field, currentArray);
    };

    useEffect(() => {
        let puntos = 0;
        if (data.caidas_previas === '1') puntos += 1;
        puntos += data.medicamentos.length; 
        puntos += data.deficits.length;
        if (data.estado_mental === 'confuso') puntos += 1;
        if (data.deambulacion !== 'normal') puntos += 1;
        if (data.edad_mayor_70) puntos += 1;
        if (data.puntaje_total !== puntos) {
            setData('puntaje_total', puntos);
        }

    }, [data.caidas_previas, data.medicamentos, data.deficits, data.estado_mental, data.deambulacion, data.edad_mayor_70]);


    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        Swal.fire({
            title: '¿Confirmar registro?',
            text: "Se guardarán los resultados del riesgo de caídas.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {        
                post(route('hojas-riesgo-caidas.store', {hojasenfermeria: hoja.id}),{
                    preserveScroll: true,
                    onSuccess: () => reset(),
                });
            }
        });    
    };

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


    const getNivelRiesgo = (puntos: number) => {
        if (puntos >= 3) return { texto: 'ALTO RIESGO', color: 'text-red-600 font-bold' };
        if (puntos >= 1) return { texto: 'MEDIANO RIESGO', color: 'text-yellow-600 font-bold' };
        return { texto: 'BAJO RIESGO', color: 'text-green-600 font-bold' };
    };

    return (
        <>
        <form onSubmit={handleSubmit} className="space-y-6">

            <SelectInput
                label='Caídas previas'
                value={data.caidas_previas}
                onChange={e => setData('caidas_previas', e)}
                options={[
                    { value: '0', label: 'No' },
                    { value: '1', label: 'Sí' },
                ]}
            />

            <div className="border p-4 rounded bg-gray-50">
                <h3>Medicamentos</h3>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-2">
                    {medicamentosList.map((med) => (
                        <div key={med.id} className="flex items-center">
                            <Checkbox
                                label='' 
                                id={`med-${med.id}`}
                                checked={data.medicamentos.includes(med.id)}
                                onChange={(e) => handleMultiCheckboxChange('medicamentos', med.id, e.target.checked)}
                            />
                            <label htmlFor={`med-${med.id}`} className="ml-2 text-sm text-gray-700">
                                {med.label}
                            </label>
                        </div>
                    ))}
                </div>
            </div>


            <div className="border p-4 rounded bg-gray-50">
                <h3>Déficits sensitivo-motores</h3>
                <div className="grid grid-cols-1 gap-2">
                    {deficitList.map((def) => (
                        <div key={def.id} className="flex items-center">
                            <Checkbox 
                                label=''
                                id={`def-${def.id}`}
                                checked={data.deficits.includes(def.id)}
                                onChange={(e) => handleMultiCheckboxChange('deficits', def.id, e.target.checked)}
                            />
                            <label htmlFor={`def-${def.id}`} className="ml-2 text-sm text-gray-700">
                                {def.label}
                            </label>
                        </div>
                    ))}
                </div>
            </div>

            <SelectInput
                label='Estado mental'
                value={data.estado_mental}
                onChange={e => setData('estado_mental', e)}
                options={[
                    { value: 'orientado', label: 'Orientado' },
                    { value: 'confuso', label: 'Confuso' },
                ]}
            />

            <SelectInput
                label='Deambulación'
                value={data.deambulacion}
                onChange={e => setData('deambulacion', e)}
                options={[
                    { value: 'normal', label: 'Normal' },
                    { value: 'segura_ayuda', label: 'Segura con ayuda' },
                    { value: 'insegura', label: 'Insegura con/sin ayuda' },
                    { value: 'imposible', label: 'Imposible' },
                ]}
            />

            <div className="flex items-center mt-4">
                <Checkbox 
                    label=''
                    id="edad_70"
                    checked={data.edad_mayor_70}
                    onChange={(e) => setData('edad_mayor_70', e.target.checked)}
                />
                <label htmlFor="edad_70" className="ml-2 text-sm text-gray-700">
                    Paciente mayor de 70 años
                </label>
            </div>

            <div className="mt-6 p-4 border-2 border-blue-100 rounded-lg text-center bg-blue-50">
                <p className="text-gray-600 uppercase text-xs tracking-wider">Puntuación Total</p>
                <div className="text-3xl font-bold text-gray-800">{data.puntaje_total} Puntos</div>
                <div className={`mt-2 ${getNivelRiesgo(data.puntaje_total).color}`}>
                    {getNivelRiesgo(data.puntaje_total).texto}
                </div>
            </div>

            <div className="flex justify-end mt-4">
                <PrimaryButton disabled={processing} type='submit'>
                    {processing ? 'Guardando...' : 'Guardar'}
                </PrimaryButton>
            </div>
        </form>
        <div className="mt-12">
            <DataTable columns={columnasRiesgoCaidas} data={hoja.hoja_riesgo_caida} />
        </div>
        </>
    );
};

export default RiesgoCaidasForm;