import { Estancia, HojaOxigeno } from '@/types';
import React from 'react';
import { useForm, router } from '@inertiajs/react';
import { route } from 'ziggy-js';

import InputText from '../ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';
import CounterTime from '@/components/counter-time';

interface Props {
    estancia: Estancia;
}

const ServiciosEspecialesForm: React.FC<Props> = ({ estancia }) => {
    
    const { data, setData, post, reset, errors, processing } = useForm({
        litros_minuto: '',
        hora_inicio: '',
        hora_fin: '',    
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojasoxigenos.store',{estancia: estancia.id }), {
            preserveScroll: true,
            onSuccess: () => reset(),
        });
    }

    const handleDateUpdate = (oxigenoId: number, newDate: string) => {
        router.patch(route('hojasoxigenos.update', oxigenoId), {
            hora_fin: newDate 
        }, {
            preserveScroll: true,
        });
    };
    
    console.log(estancia);
    return (

        

        <>
            <form onSubmit={handleSubmit}>
                <div className='grid grid-cols-1 md:grid-cols-2 gap-5'>
                    <InputText
                        id="litros_minuto"
                        name="litros_minuto"
                        label="Litros por minuto"
                        value={data.litros_minuto}
                        onChange={(e) => setData('litros_minuto', e.target.value)}
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
                                <th className="px-4 py-4 text-sm text-gray-900">Tiempo transcurrido</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Hora de fin</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Litros por minuto</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Total litros consumidos</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Personal que inició</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Personal que finalizó</th>
                            </tr>
                        </thead>
                        <tbody>
                            {(estancia.hoja_oxigenos ?? []).length === 0 ? (
                                <tr className='text-center'>
                                    <td colSpan={3} className='px-4 py-4 text-sm text-gray-500 text-center'>
                                        No hay aplicaciones de oxígeno registradas
                                    </td>
                                </tr>
                            ) : (
                                (estancia.hoja_oxigenos ?? []).map((oxi: HojaOxigeno) => (
                                    <tr key={oxi.id}>
                                        <td className="px-4 py-4 text-sm text-gray-900">{oxi.hora_inicio}</td>
                                        <td>
                                            <CounterTime
                                                fechaInicioISO={oxi.hora_inicio}
                                                fechaFinISO={oxi.hora_fin}
                                            />
                                        </td>
                                        <td className="px-4 py-4 text-sm text-gray-900">
                                            {oxi.hora_fin ? (
                                                <span>{oxi.hora_fin}</span>
                                            ) : (
                                                <PrimaryButton
                                                    onClick={() => {
                                                        const now_iso = new Date().toISOString(); 
                                                        handleDateUpdate(oxi.id, now_iso);
                                                    }}
                                                >
                                                    Registrar fin
                                                </PrimaryButton>
                                            )}
                                        </td>
                                        <td className="px-4 py-4 text-sm text-gray-900">{oxi.litros_minuto}</td>
                                        <td className="px-4 py-4 text-sm text-gray-900">{oxi.total_consumido }</td>
                                        <td className="px-4 py-4 text-sm text-gray-900">{oxi.user_inicio?.nombre} {oxi.user_inicio?.apellido_paterno} {oxi.user_inicio?.apellido_materno}</td>
                                        <td className="px-4 py-4 text-sm text-gray-900">{}</td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    )
}

export default ServiciosEspecialesForm;