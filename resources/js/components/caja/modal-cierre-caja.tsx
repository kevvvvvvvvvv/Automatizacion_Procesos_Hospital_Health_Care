import React, { useEffect, useState } from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';
import { SesionCaja } from '@/types';

import PrimaryButton from '../ui/primary-button';
import MoneyInput from '../ui/input-money';

interface Props {
    onClose: () => void;
    sesion: SesionCaja;
    fondo: SesionCaja;
}

const ModalCierreCaja = ({ 
    onClose,
    sesion,
    fondo,
}: Props) => {
    const { data, setData, post, processing, errors } = useForm({
        monto_declarado: '',
        monto_enviado_contaduria: '0',
    });

    const [montoRestante, setMontoRestante] = useState(0);

    const formatMoney = (amount: number) => {
        return Number(amount || 0).toLocaleString('es-MX', { minimumFractionDigits: 2 });
    };

    useEffect(() => {
        const declarado = Number(data.monto_declarado) || 0;
        const enviado = Number(data.monto_enviado_contaduria) || 0;
        
        setMontoRestante(declarado - enviado);
    }, [data.monto_declarado, data.monto_enviado_contaduria]);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        if(Number(data.monto_declarado) < Number(data.monto_enviado_contaduria)){
            Swal.fire(
                'Advertencia',
                'Estás enviando más dinero del que se encuentra actualmente en caja principal.',
                'warning'
            );
            return;
        }
        
        Swal.fire({
            title: '¿Cerrar el turno?',
            text: "Se realizará el corte de caja y esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',  
            confirmButtonText: 'Sí, cerrar caja',
            cancelButtonText: 'Cancelar',
            reverseButtons: true 
        }).then((result) => {
            if (result.isConfirmed) {
                post(route('caja-cerrar'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        onClose();
                    },
                });
            }
        });
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-opacity-60 p-4 backdrop-blur-sm">
            <div className="relative w-full max-w-md rounded-xl bg-white p-6 shadow-2xl border-t-4 border-red-500">
                <button onClick={onClose} className="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <h3 className="mb-2 text-xl font-bold text-gray-800">Corte y cierre de caja</h3>
                <p className="mb-6 text-sm text-gray-500">
                    Por favor, cuenta el dinero físico que hay en el cajón y escribe el total. El sistema calculará automáticamente si hay algún faltante o sobrante.
                </p>
                <p>Dinero esperado en caja: ${formatMoney(sesion.monto_esperado)}</p>
                {fondo && (
                    <p>Dinero esperado en fondo: ${formatMoney(fondo.monto_esperado)}</p>
                )}
                <p>Dinero para el siguiente turno: ${formatMoney(montoRestante)}</p>

                <form onSubmit={handleSubmit} className="py-8">
                    <MoneyInput
                        id=''
                        name=''
                        label='Monto disponible'
                        value={data.monto_declarado}
                        onValueChange={(e) => setData('monto_declarado',e ?? '')}
                        error={errors.monto_declarado}
                    />
                    {fondo && ( 
                        <MoneyInput
                            id=''
                            name=''
                            label='Monto a enviar a contaduría'
                            value={data.monto_enviado_contaduria}
                            onValueChange={e => setData('monto_enviado_contaduria', e ?? '')}
                            error={errors.monto_enviado_contaduria}
                        />
                    )}

                    <div className="mt-8 flex justify-end space-x-3">
                        <PrimaryButton
                            type='submit'
                            disabled={processing}
                        >
                            Cerrar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default ModalCierreCaja;