import React from 'react';
import { useForm } from '@inertiajs/react';
import Swal from 'sweetalert2';
import { SesionCaja } from '@/types/index';
import { route } from 'ziggy-js';

import { SummaryCard } from '../ui/money/summary-card';
import TextInput from '@/components/ui/input-text';
import PrimaryButton from '../ui/primary-button';
import MoneyInput from '../ui/input-money';
import SelectInput from '../ui/input-select';


interface Props {
    onClose: () => void;
    boveda: SesionCaja;
    fondos: SesionCaja[];
}

const ModalEnviarBovedaAFondo = ({ 
    onClose, 
    boveda, 
    fondos = [],
}: Props) => {
    const { data, setData, post, processing, errors } = useForm({
        monto_envio: '',
        observacion: '',
        sesion_origen_id: boveda.id,
        sesion_destino_id: '',
    });



    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        if (Number(data.monto_envio) > Number(boveda.monto_esperado)) {
            Swal.fire('Saldo insuficiente', 'No hay tanto dinero en Bóveda.', 'error');
            return;
        }

        Swal.fire({
            title: '¿Confirmar traspaso?',
            text: `Se moverán $${data.monto_envio} de Bóveda a Fondo inmediatamente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, transferir ahora',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#2563eb',
        }).then((result) => {
            if (result.isConfirmed) {
                post(route('boveda.traspaso-directo'), {
                    onSuccess: () => {
                        onClose();
                    }
                });
            }
        });
    };

    const fondosOptions = fondos.map( fondo => (
        { value: fondo.id, label: fondo.caja?.nombre ?? 'Sin nombre' }
    ))

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div className="w-full max-w-md bg-white rounded-xl shadow-2xl p-6 border-t-4 border-blue-600">
                <h3 className="text-xl font-bold text-gray-800 mb-4">Traspaso directo a fondo</h3>
                
                <SummaryCard
                    label='Monto disponible en boveda'
                    amount={boveda.monto_esperado}
                    mostrarValor={false}
                />

                <form onSubmit={handleSubmit} className="space-y-4">

                    <MoneyInput
                        id=''
                        name=''
                        label="Monto a traspasar"
                        value={data.monto_envio}
                        onValueChange={e => setData('monto_envio', e ?? '')}
                        error={errors.monto_envio}
                    />

                    <SelectInput
                        label='Fondo a depositar'
                        value={data.sesion_destino_id}
                        onChange={ e => setData('sesion_destino_id', e)}
                        options={fondosOptions}
                    />

                    <TextInput
                        id=''
                        name=''
                        label='Concepto'
                        value={data.observacion}
                        onChange={e=>setData('observacion',e.target.value)}
                    />

                    <div className="flex justify-end space-x-3 pt-4">
                        <button type="button" onClick={onClose} className="text-sm font-bold text-gray-500">
                            Cancelar
                        </button>
                        <PrimaryButton 
                            disabled={processing}
                            type='submit'
                        >
                            {processing ? 'Enviando...' : 'Enviar'}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default ModalEnviarBovedaAFondo;