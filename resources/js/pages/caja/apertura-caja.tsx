import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Caja } from '@/types';

import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import MoneyInput from '@/components/ui/input-money';

interface Props {
    cajas: Caja[];    
}

export const AperturaCaja = ({ 
    cajas = [],
}: Props) => {

    const cajaOptions = cajas.map((caja) => (
        { value: caja.id, label: caja.nombre}
    ))

    const { data, setData, post, processing, errors } = useForm({
        caja_id: '',
        monto_inicial: ''
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('caja-abrir-turno')); 
    };

    return (
        <div className="max-h-screen flex items-center justify-center p-4">
            <div className="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
                <h2 className="text-2xl font-bold text-gray-800 mb-6 text-center">Apertura de turno</h2>
                
                <form onSubmit={handleSubmit} className="space-y-5">
                    <SelectInput
                        label='Caja'
                        options={cajaOptions}
                        value={data.caja_id}
                        onChange={e=>setData('caja_id',e)}
                        error={errors.caja_id}
                    />

                    <MoneyInput
                        label='Monto inicial'
                        id='monto_inicial'
                        name='monto_inicial'
                        value={data.monto_inicial}
                        onValueChange={e=>setData('monto_inicial',e ?? '')}
                        error={errors.monto_inicial}
                    />

                    <div className='flex items-end justify-end'>
                        <PrimaryButton
                            type='submit'
                            disabled={processing}
                        >
                            Iniciar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
};