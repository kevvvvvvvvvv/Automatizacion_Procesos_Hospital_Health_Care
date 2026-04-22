import React from 'react';
import { useForm } from '@inertiajs/react';
import { SesionCaja } from '@/types';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

import TextInput from '../ui/input-text';
import PrimaryButton from '../ui/primary-button';
import MoneyInput from '../ui/input-money';

interface Props {
    sesionActiva: SesionCaja;
    sesionFondo: SesionCaja;
    onClose: () => void;
}

export const ModalSolicitudFondo = ({ 
    sesionActiva,
    sesionFondo,
    onClose
}: Props) => {
    const { data, setData, post, processing, errors } = useForm({
        caja_origen_id: 2, // Fondo inciado por el contador
        caja_destino_id: sesionActiva.caja_id,
        monto: '',
        concepto: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if(sesionFondo.monto_esperado < Number(data.monto)){
            Swal.fire(
                'Advertencia',
                'Estás retirando más dinero del que se encuentra actualmente en fondo, solicita un ingreso a fondo o un ajuste.',
                'warning'
            )
            return;
        }
        post(route('traspasos.solicitar'), {
            preserveScroll: true,
            onSuccess: () => {
                onClose();
            }  
        });
    };

    return (
        <div className="fixed inset-0 flex items-center justify-center z-50 p-4 backdrop-blur-sm">
            <div className="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
                <div className="bg-blue-600 px-6 py-4 flex justify-between items-center">
                    <h3 className="text-lg font-bold text-white">Solicitar efectivo al fondo</h3>
                    <button onClick={onClose} className="text-white hover:text-gray-200 text-xl font-bold">&times;</button>
                </div>

                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    <TextInput
                        id='concepto'
                        name='concepto'
                        label='Concepto'
                        value={data.concepto}
                        onChange={e=>setData('concepto',e.target.value)}
                        error={errors.concepto}
                    />

                    <MoneyInput
                        id=''
                        name=''
                        label='Total dinero retirado'
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
                        >
                            {processing ? 'Guardando...' : 'Guardar'}
                        </PrimaryButton>

                    </div>
                </form>
            </div>
        </div>
    );
};