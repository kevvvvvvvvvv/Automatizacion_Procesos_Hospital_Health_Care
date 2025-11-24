import { HojaEnfermeria, HojaOxigeno } from '@/types';
import React from 'react';
import { useForm, router } from '@inertiajs/react';
import { route } from 'ziggy-js';

import InputText from '../ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';

interface Props {
    hoja:HojaEnfermeria
}

const ServiciosEspecialesForm:React.FC<Props> = ({hoja}) => {
    
    const {data, setData, post, reset, errors, processing} = useForm({
        litros_minuto: '',
        hora_inicio: '',
        hora_fin: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojasoxigenos.store',{hojasenfermeria: hoja.id}),{
            preserveScroll: true,
            onSuccess:() => reset(),
        });
    }

    const handleDateUpdate = (oxigenoId: number, newDate: string) => {
        router.patch(route('hojasmedicamentos.update', { 
            hojasenfermeria: hoja.id, 
            hojasmedicamento: oxigenoId 
        }), {
            fecha_hora_inicio: newDate 
        }, {
            preserveScroll: true,
            onError: (errors) => {
                alert('Error al actualizar: \n' + JSON.stringify(errors));
            }
        });
    };
    
    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className='grid grid-cols-1 md:grid-cols-2 gap-5'>
                    {/*<InputDateTime
                        label='Hora de inicio'
                        name="hora_inicio"
                        id="hora_inicio"
                        value={data.hora_inicio}
                        onChange={(e)=>setData('hora_inicio',e)}
                        error={errors.hora_inicio}
                    />*/}
                    <InputText
                        id="litros_minuto"
                        name="litros_minuto"
                        label="Litros por minuto"
                        value={data.litros_minuto}
                        onChange={(e)=>setData('litros_minuto',e.target.value)}
                        error={errors.litros_minuto}
                        type="number"
                    />
                </div>
                <div className='flex justify-end mt-4'>
                    <PrimaryButton type="submit" disabled={processing || !data.litros_minuto}>
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </form>
            <div className='mt-12'>
                <h3 className='text-lg font-semibold mb-2'>Historial del uso de oxígeno</h3>
                <div className='overflow-x-auto border rounded-lg'>
                    <table className='min-w-full divide-y divide-gray-200'>
                        <thead>
                            <tr>
                                <th className="px-4 py-4 text-sm text-gray-900">Hora de inicio</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Hora de fin</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Litros por minuto</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Total de litros usados</th>
                            </tr>
                        </thead>
                        <tbody>
                            {(hoja.hoja_oxigeno ?? []).length === 0 ?(
                                <tr className='text-center'>
                                    <td className='px-4 py-4 text-sm text-gray-500 text-center'>
                                        No hay aplicaciones de oxígeno registradas
                                    </td>
                                </tr>
                            ):
                            ((hoja.hoja_oxigeno ?? []).map((oxi: HojaOxigeno)=>(
                                <tr key={oxi.id}>
                                    <td className="px-4 py-4 text-sm text-gray-900">{oxi.hora_inicio}</td>
                                    <td className="px-4 py-4 text-sm text-gray-900">{oxi.hora_fin ? (
                                        <span>{oxi.hora_fin}</span>
                                    ):(
                                        <PrimaryButton
                                        onClick={()=>{
                                            const now_iso = new Date().toISOString();
                                            handleDateUpdate(oxi.id, now_iso);
                                        }} 
                                        >
                                            Registrar fin
                                        </PrimaryButton>
                                    )}
                                    </td>
                                    <td className="px-4 py-4 text-sm text-gray-900">{oxi.litros_minuto}</td>
                                </tr>
                            )))}
                    </tbody>
                    </table>

                </div>
            </div>
        </>
    )
}

export default ServiciosEspecialesForm;