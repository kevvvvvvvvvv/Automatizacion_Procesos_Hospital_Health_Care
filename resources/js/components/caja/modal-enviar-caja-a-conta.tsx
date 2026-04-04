import React from 'react';
import { useForm } from '@inertiajs/react';
import { SesionCaja } from '@/types'; 
import { route } from 'ziggy-js';

import TextInput from '../ui/input-text';
import PrimaryButton from '../ui/primary-button';
import Swal from 'sweetalert2';

interface Props {
    sesionActiva: SesionCaja;
    onClose: () => void;
}

const ModalEnviarCajaAConta = ({ sesionActiva, onClose }: Props) => {
    
    const { data, setData, post, processing, errors, reset } = useForm({
        caja_origen_id: sesionActiva.caja_id, // El dinero sale de esta caja
        caja_destino_id: 3, //Dinero de la caja del conta (boveda)
        monto: '',
        concepto: 'Exceso de efectivo enviado a contaduría',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        if(sesionActiva.monto_esperado < Number(data.monto)){
            Swal.fire(
                'Advertencia',
                'Estás enviando más dinero del que se encuentra actualmente en caja principal.',
                'warning',
            );
            return;
        }

        post(route('traspasos.enviarABoveda'), {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                onClose();
            },
        });
    };

    return (
        <div className="fixed inset-0  bg-opacity-50 flex items-center justify-center z-50 p-4 backdrop-blur-sm">
            <div className="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
                <div className="bg-purple-700 px-6 py-4 flex justify-between items-center">
                    <h3 className="text-lg font-bold text-white">Enviar efectivo a contaduría</h3>
                    <button onClick={onClose} className="text-white hover:text-gray-200 text-xl font-bold">&times;</button>
                </div>

                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    <div className="bg-purple-50 p-3 rounded-md text-sm text-purple-800 border border-purple-100 mb-4">
                        El dinero se descontará de tu caja en cuanto Contaduría apruebe la recepción.
                    </div>

                    <TextInput
                        id='concepto'
                        name='concepto'
                        label='Concepto'
                        value={data.concepto}
                        onChange={e => setData('concepto', e.target.value)}
                        error={errors.concepto}
                    />

                    <TextInput
                        id='monto'
                        name='monto'
                        label='Total de dinero a enviar'
                        value={data.monto}
                        onChange={e => setData('monto', e.target.value)}
                        error={errors.monto}
                    />

                    <div className="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                        <button 
                            type="button" 
                            onClick={onClose} 
                            className="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors"
                        >
                            Cancelar
                        </button>

                        <PrimaryButton
                            type='submit'
                            disabled={processing}
                            className='bg-purple-600'
                        >
                            {processing ? 'Enviando...' : 'Enviar a contaduría'}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default ModalEnviarCajaAConta;