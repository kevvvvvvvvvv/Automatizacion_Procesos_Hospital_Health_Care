import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js'
import Swal from 'sweetalert2';
import { SesionCaja } from '@/types';

import TextInput from '@/components/ui/input-text';
import PrimaryButton from '../ui/primary-button';
import MoneyInput from '../ui/input-money';

interface Props {
    sesionBovedo: SesionCaja;
    onClose: () => void;
}

export const ModalGastoBoveda = ({ 
    onClose,
    sesionBovedo,
}: Props) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        caja_origen_id: 3, //ID por defecto de la boveda
        monto: '',
        concepto: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        if(Number(data.monto) > sesionBovedo.monto_esperado){
            Swal.fire(
                'Advertencia',
                'Estás retirando más dinero del que se encuentra actualmente en bóveda. Solicita un ajusta.',
                'warning'
            )
            return;
        }

        post(route('boveda.registrarGasto'), {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                onClose();
            },
        });
    };

    return (
        <div className="fixed inset-0 flex items-center justify-center z-50 p-4 backdrop-blur-sm">
            <div className="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
                <div className="bg-red-600 px-6 py-4 flex justify-between items-center">
                    <h3 className="text-lg font-bold text-white">Registrar pago externo</h3>
                    <button onClick={onClose} className="text-white hover:text-gray-200 text-xl font-bold">&times;</button>
                </div>

                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    <TextInput
                        id=''
                        name=''
                        label='Concepto'
                        value={data.concepto}
                        onChange={e=>setData('concepto',e.target.value)}
                        error={errors.concepto}
                    />

                    <MoneyInput
                        id=''
                        name=''
                        label='Monto'
                        value={data.monto}
                        onValueChange={e=>setData('monto',e ?? '')}
                        error={errors.monto}
                    />

                    <div className="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                        <button type="button" onClick={onClose} className="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancelar
                        </button>
                        <PrimaryButton
                            type='submit'
                            disabled={processing}
                            className="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 font-bold shadow-sm"
                        >
                            {processing ? 'Guardando...' : 'Confirmar pago'}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
};